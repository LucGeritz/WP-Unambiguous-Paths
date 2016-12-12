<?php
namespace Tigrez;

class Path{
	
	private static $doTrail = false;
	
	private static function isChildTheme(){
		return !(get_template_directory() === get_stylesheet_directory());	
	} 
	
	/* use uniform forward separator */
	private static function separate($path){
		return str_replace('\\','/',$path);	
	}
	
	/* paste trailing slash */	
	private static function trail($path,$trailer='/'){
		self::$doTrail = false;
		return trim($path,$trailer).$trailer;
	}
	
	/* separate and trail */
	private static function normalize($path, $sub=''){
		
		if($sub) $path=$path.'/'.$sub;
		
		$path = self::separate($path);	
		if(self::$doTrail) $path = self::trail($path);
		return $path;
		
	}
	
	/* force result of next methos to contain trailing slash */
	public static function trailingSlash(){
		self::$doTrail = true;
		return new self();	
	}
	
	/* the path functions */
	
	public static function hostUrl($sub=''){
		$host='';
		if ( isset($_SERVER['HTTP_HOST']) ) $host = $_SERVER['HTTP_HOST'];
		if ( isset($_SERVER['SERVER_NAME']) ) $host = $_SERVER['SERVER_NAME'];
		return self::normalize($host, $sub);
	}
	
	public static function parentThemeUrl($sub=''){
		$path = get_template_directory_uri();
		return self::normalize($path, $sub);
	}

	public static function parentThemeFolder($sub=''){
		$path = get_template_directory();
		return self::normalize($path, $sub);
	}
	
	public static function childThemeUrl($sub=''){
		if(!self::isChildTheme()) return '';
		$path = dirname(get_stylesheet_uri());
		return self::normalize($path, $sub);
	}

	public static function childThemeFolder($sub=''){
		if(!self::isChildTheme()) return '';
		$path = get_stylesheet_directory();
		return self::normalize($path, $sub);
	}

	public static function themeUrl($sub=''){
		$path = dirname(get_stylesheet_uri());
		return self::normalize($path, $sub);
	}

	public static function themeFolder($sub=''){
		$path = get_stylesheet_directory();
		return self::normalize($path, $sub);
	}
	
	public static function uploadBaseFolder($sub=''){
		$paths = wp_upload_dir();
		$path = $paths['basedir'];	
		return self::normalize($path, $sub);
	}
	
	public static function uploadBaseUrl($sub=''){
		$paths = wp_upload_dir();
		$path = $paths['baseurl'];	
		return self::normalize($path, $sub);
	}

	public static function uploadFolder($sub=''){
		$paths = wp_upload_dir();
		$path = $paths['path'];	
		return self::normalize($path, $sub);
	}
	
	public static function uploadUrl($sub=''){
		$paths = wp_upload_dir();
		$path = $paths['url'];	
		return self::normalize($path, $sub);
	}
	
	public static function pluginFolder($sub=''){
		$path = dirname(dirname(__FILE__));
		return self::normalize($path, $sub);
	}
	
	public static function rootFolder($sub=''){
		$path = ABSPATH;
		return self::normalize($path, $sub);
	}
	
	public static function scheme() 
    {
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        if(self::$doTrail){
			$scheme = self::trail($scheme, '://');
		}
		return $scheme;
    }
}