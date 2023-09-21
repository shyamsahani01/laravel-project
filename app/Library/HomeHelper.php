<?php
namespace App\Library;
use App\Models\ContentPage;
use Helper;
class HomeHelper {
	public static function Homepage(){
		$banner_heading =  ContentPage::where('status','AC')->where('slug','banner_heading')->value('content');
		$banner_content =  ContentPage::where('status','AC')->where('slug','banner_content')->value('content');
		$qualified_lawyers =  ContentPage::where('status','AC')->where('slug','qualified_lawyers')->value('content');
		$trusted_clients =  ContentPage::where('status','AC')->where('slug','trusted_clients')->value('content');
		$successful_cases =  ContentPage::where('status','AC')->where('slug','successfull_cases')->value('content');
		$awards =  ContentPage::where('status','AC')->where('slug','awards')->value('content');
		$ambassador_heading =  ContentPage::where('status','AC')->where('slug','ambassador_heading')->value('content');
		$user_image = ContentPage::where('status','AC')->where('slug','user_image')->value('content');
		return ['banner_heading'=>$banner_heading,'banner_content'=>$banner_content,'qualified_lawyers'=>$qualified_lawyers,
		        'trusted_clients'=>$trusted_clients,'successful_cases'=>$successful_cases,
				'awards'=>$awards,'ambassador_heading'=>$ambassador_heading,'user_image'=>$user_image
	           ];
	}
}
?>