<?php

namespace Govpack\Core;

use Govpack\Vendor\z4kn4fein\SemVer\Version;

class Dev_Helpers{
	
	private Govpack $plugin;

	private bool $is_git;
	private bool $has_version_file;
	private string $branch;
	private string $build_number;
	private string $release_label;
	private Version $version;

	public function __construct(Govpack $plugin){
		$this->plugin = $plugin;
	}


	public function hooks(){
		add_filter("plugins_list", [$this, "filter_version"]);
	}

	/*
	Filter the version number the plugin shows in the Plugin Table
	*/
	public function filter_version($plugins){

		$plugin_file = "govpack/govpack.php";
	
		foreach($plugins as $group_key => $group ){
			if(!isset($plugins[$group_key][$plugin_file])){
				continue;
			}
			$plugins[$group_key][$plugin_file]["Version"] = $this->generate_version_string($plugins[$group_key][$plugin_file]["Version"]);
		}
		
		return $plugins;
	}

	/**
	 * Create the new version string by suffuxing the current version with the result 
	 * of `get_version_suffix`. Usually a build number, git branch name or version 
	 * tag
	 */
	public function generate_version_string($current_version){
		$suffix = $this->get_version_suffix();
		if(!$suffix){
			return $current_version;
		}
		return sprintf("%s-%s", $current_version, $suffix);
	}

	/**
	 * Get the version suffix
	 */
	public function get_version_suffix() : ?string {

		if($this->label() !== ""){
			return $this->label();
		} elseif ($this->build_number() !== ""){
			return $this->build_number();
		} elseif($this->is_git_repo()) {
			return $this->get_git_branch();
		} elseif ($this->is_composer()){
			return $this->get_composer_ref();
		}

		return null;
	}

	public function get_composer_ref() : string {
		$ref = \Composer\InstalledVersions::getReference('govpack/govpack') ?? "";
		if($ref){
			$ref = substr($ref, 0, 7);
		}
		return $ref;
	}
	public function is_composer(){
		
		return file_exists($this->plugin->path("composer.lock"));
	}

	public function build_number() : string {
		if(isset($this->build_number)){
			return $this->build_number;
		}

		if(!$this->has_version_file()){
			return "";
		}

		try{
			$this->build_number = $this->get_version()->getBuildMeta() ?? "";
			return $this->build_number;

		} catch (\Exception $e){
			return "";
		}
	}

	public function get_version() : Version{
		if(isset($this->version)){
			return $this->version;
		}

		$version = include_once($this->version_file_path());

		$this->version =  Version::parse($version);

		return $this->version;
		
	}

	public function label() : string {
		if(isset($this->release_label)){
			return $this->release_label;
		}

		if(!$this->has_version_file()){
			return "";
		}

		try{
			$this->release_label = $this->get_version()->getPreRelease() ?? "";
			return $this->release_label;

		} catch (\Exception $e){
			return "";
		}
	}

	public function version_file_path(){
		return $this->plugin->path("version.php");
	}

	public function has_version_file(){
		return file_exists($this->version_file_path());
	}

	public function is_git_repo(){
		if(isset($this->is_git)){
			return $this->is_git;
		}

		$this->is_git = file_exists($this->plugin->path(".git/HEAD"));

		return $this->is_git;
	}

	public function get_git_branch() : string{
		
		if(isset($this->branch)){
			return $this->branch;
		}

		// this might get called accidentally, make sure it doesn't
		if(!$this->is_git_repo()){
			return "";
		}

		/*
		The head file will be structured something like this -  `ref: refs/heads/branch-name`
		By exploding the string on the "/" we can split it up.  Forward Slash "/" is a common 
		character in branch names, especially in git flow. We have to limit the fragments from 
		the explosion to 3 so any /'s in te branch name are preserved eg 
		1. ref: refs
		2. heads
		3. branch-name
		*/
		try{

			$git_head_file = file_get_contents($this->plugin->path(".git/HEAD"), true);
			$ref = explode("/", $git_head_file, 3);
			$this->branch = rtrim($ref[2]);
			return $this->branch;

		} catch( \Exception $e) {
			return "";
		}
	}
}