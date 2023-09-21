<?php
namespace App\Library;
use Auth;
use DB;
use Config;
class WebHelper {

	public static function get_emr_design_file_location($design_category = '', $design_type = '', $design_code = '', $image_type = '')
	{
		$file_url = "";
		$folder = "mahapura";
		$file_ext = [".jpg", ".jpeg", ".png", ".JPG", ".JPEG", ".PNG"];

		if(auth()->user()->emrDB == 'Sitapura') { $folder = "sitapura"; }

		if($image_type == '3D' || $image_type == '') {

			// $file_loc = "/var/www/vendorportal/public/emr/$folder/3D/$design_category/";
			$file_loc = "/var/www/vendorportal/public/emr/$folder/3D/$design_category/";
			$file_name = "$design_type 3D $design_code";

			for ($i=0; $i <count($file_ext) ; $i++) {
				if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
				{
						$file_url = "https://reports.pinkcityindia.com/public/emr/$folder/3D/$design_category/$file_name$file_ext[$i]";
						break;
				}
			}
		}

		if($image_type == 'LD' || $image_type == '') {

			$file_loc = "/var/www/vendorportal/public/emr/$folder/LD/$design_category/";
			$file_name = "$design_type LD $design_code";

			for ($i=0; $i <count($file_ext) ; $i++) {
				if( file_exists($file_loc . $file_name . $file_ext[$i] ) )
				{
					$file_url = "https://reports.pinkcityindia.com/public/emr/$folder/LD/$design_category/$file_name$file_ext[$i]";
					break;
				}
			}

		}




		return $file_url;

	}


}
?>
