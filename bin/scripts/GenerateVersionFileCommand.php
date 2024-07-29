<?php

namespace Govpack\Scripts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use z4kn4fein\SemVer\Version;

class GenerateVersionFileCommand extends Command{

	protected Filesystem $fs;

	protected string $filename = "version.php";
	protected array $plugin_headers;

	protected function configure(): void
    {
		$this->setDefinition([
            new InputOption('major', null, InputOption::VALUE_REQUIRED, 'Example flag'),
			new InputOption('minor', null, InputOption::VALUE_REQUIRED, 'Example flag'),
			new InputOption('patch', null, InputOption::VALUE_REQUIRED, 'Example flag'),
			new InputOption('pre-release', null, InputOption::VALUE_REQUIRED, 'Example flag'),
			new InputOption('build', null, InputOption::VALUE_REQUIRED, 'Example flag'),
			new InputOption('build-from-composer', null, InputOption::VALUE_NONE, 'Example flag'),
        ]);
    }

	public function execute(InputInterface $input, OutputInterface $output): int
    {	
		if($this->versionFileExists()){
			$this->removeVersionFile();		
		}
		
		$this->fs()->dumpFile(
			$this->filename, 
			$this->generateCode(
				$this->getVersion($input, $output)
			)
		);

        return 0;
    }

	private function getPluginFileVersion() : Version{
		$plugin_version = $this->getPluginFileHeader("Version");
		return Version::parse($plugin_version);
	}

	private function getPluginFileHeader(string $header) : string {
		$headers = $this->getPluginFileHeaders();
		return $headers[$header];
	}

	private function getPluginFileHeaders(){

		if(isset($this->plugin_headers)){
			return $this->plugin_headers;
		}
		
		$file = "govpack.php";

		$default_headers = array(
			'Name'            => 'Plugin Name',
			'PluginURI'       => 'Plugin URI',
			'Version'         => 'Version',
			'Description'     => 'Description',
			'Author'          => 'Author',
			'AuthorURI'       => 'Author URI',
			'TextDomain'      => 'Text Domain',
			'DomainPath'      => 'Domain Path',
			'Network'         => 'Network',
			'RequiresWP'      => 'Requires at least',
			'RequiresPHP'     => 'Requires PHP',
			'UpdateURI'       => 'Update URI',
			'RequiresPlugins' => 'Requires Plugins',
			// Site Wide Only is deprecated in favor of Network.
			'_sitewide'       => 'Site Wide Only',
		);

			// Pull only the first 8 KB of the file in.
		$file_data = file_get_contents( $file, false, null, 0, 8 * 1024 );
		
		if ( false === $file_data ) {
			$file_data = '';
		}
		
		// Make sure we catch CR-only line endings.
		$file_data = str_replace( "\r", "\n", $file_data );
		
		$this->plugin_headers = $default_headers;
			
		foreach ( $this->plugin_headers as $field => $regex ) {
			if ( preg_match( '/^(?:[ \t]*<\?php)?[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ) {
				$this->plugin_headers[ $field ] = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $match[1]) );
			} else {
				$this->plugin_headers[ $field ] = '';
			}
		}
	
		return $this->plugin_headers;
		
	}

	private function getVersion(InputInterface $input, OutputInterface $output,): string {

		$io = new SymfonyStyle($input, $output);

		$version = Version::create(0,1,0);

		$fragments = [
			"major" => 0,
			"minor" => 0,
			"patch" => 0,
			"pre_release" => null,
			"build" => null,
		];

		if( !$input->getOption("major") && !$input->getOption("minor") && !$input->getOption("minor")){

			$plugin_version = $this->getPluginFileVersion();
			$fragments['major'] = $plugin_version->getMajor();
			$fragments['minor'] = $plugin_version->getMinor();
			$fragments['patch'] = $plugin_version->getPatch();

		} else if( !$input->getOption("major") || !$input->getOption("minor") || !$input->getOption("minor")){

			$io->note("All primary version pieces must be passed or none. One or more of major, minor or patch is missing. Version will be taken from the plugin file instead");

			$plugin_version = $this->getPluginFileVersion();
			$fragments['major'] = $plugin_version->getMajor();
			$fragments['minor'] = $plugin_version->getMinor();
			$fragments['patch'] = $plugin_version->getPatch();

		} else {
			
			if($input->getOption("major")){
				$fragments["major"] = $input->getOption("major");
			}

			if($input->getOption("minor")){
				$fragments["minor"] = $input->getOption("minor");
			}

			if($input->getOption("patch")){
				$fragments["patch"] = $input->getOption("patch");
			}

		}

		if($input->getOption("pre-release")){
			$fragments["pre_release"] = $input->getOption("pre-release");
		}

		if($input->getOption("build") && !$input->getOption("build-from-composer") ){
			$fragments["build"] = $input->getOption("build");
		} elseif ($input->getOption("build-from-composer")) {
			$fragments["build"] = $this->getBuildFromComposer();
		}

		$version = Version::create(
			$fragments['major'],
			$fragments['minor'],
			$fragments['patch'],
			$fragments['pre_release'],
			$fragments['build'],
		);

		return $version->__toString();
	}

	private function getBuildFromComposer() : string {
		$ref = \Composer\InstalledVersions::getReference('govpack/govpack');
		$short_ref = substr($ref, 0, 7);
		return $short_ref;
	}

	private function generateCode($version) : string {
		
		if($version === ""){
			return "";
		}

		$code = sprintf("<?php  \r\n return %s;", var_export($version, true));
		return $code;
	}



	public function createVersionFile() : void{
		$this->fs()->touch($this->filename);
	}

	public function removeVersionFile() : void{
		$this->fs()->remove($this->filename);
	}

	public function versionFileExists() : bool {
		return $this->fs()->exists($this->filename);
	}

	protected function fs() : Filesystem {

		if(!isset($this->fs)){
			$this->fs = new Filesystem();
		}

		return $this->fs;
	}
}