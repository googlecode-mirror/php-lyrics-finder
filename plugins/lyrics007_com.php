<?php 

class lyrics {
	public function search_result($search, $filename){
	function current_page($while_data){
			$data = explode('src="http://pagead2.googlesyndication.com/pagead/show_ads.js">', getdata("http://www.lyrics007.com/search.php?q=".replace_space($search)."&page=".$while_data, $curl));
			$data = explode('<a href="', $data[1]);
			$data = explode('Documents', $data[0]);
			$data = explode('..', $data[1]);
			return $data[0];
		}
		function all_page(){
			$data = explode('src="http://pagead2.googlesyndication.com/pagead/show_ads.js">', getdata("http://www.lyrics007.com/search.php?q=".replace_space($search)."&page=1", $curl));
			$data = explode('<a href="', $data[1]);
			$data = explode('total', $data[0]);
			$data = explode('found', $data[1]);
			return $data[0];
		}
		$getdata_page1 = getdata("http://www.lyrics007.com/search.php?q=".replace_space($search)."&page=1", $curl);
		if(strpos($getdata_page1, "No Results for '".$_POST['lagu']."'")){
			echo "<center>Either Mispelling or Search Not Found</center>";
		} else {
			$page = 1;
			while ($page <= 100) {
				$getdata_utama_search = getdata("http://www.lyrics007.com/search.php?q=".replace_space($search)."&page=".$page, $curl);
				$getdata = explode('src="http://pagead2.googlesyndication.com/pagead/show_ads.js">', $getdata_utama_search);
				$getdata = explode('<div style="float:right;width:160px">', $getdata[1]);
				$getdata = explode('click.php?url=', $getdata[0]);
				foreach($getdata as $pecah){
					$explode = explode('</strong>', $pecah);
					$explode = explode('</script>', $explode[0]);
					$explode = explode('</div>', $explode[0]);
					$explode = explode('" target="_blank"><strong>', $explode[0]);
					if(count($explode) != 1){
						$string = str_replace('http://www.lyrics007.com', '', $explode[0]).":".$explode[1].":".str_replace(".php", "", str_replace("_", ".", $filename));
						echo "<center><a href='?lyrics=".encode_url($string, "encode")."'>".$explode[1]."</a><br></center>";
					}
				}
				if(current_page($page)>=all_page()){$page = $page + 100;}else{$page = $page + 1;}
			}
		}
	}
	public function get_result($request){
		$request = encode_url($request, "decode");
		$getname = explode(':', $request);
		$url = replace_space("http://www.lyrics007.com".$getname[0]);
		$getlyrics = getdata("$url", $curl);
		$getlyrics = explode('display:block;float:left;padding-top:5px;', $getlyrics);
		$getlyrics = explode('/print.php?id=TWpnNE1qVTE', $getlyrics[1]);
		$getlyrics = explode('</fb:like>', $getlyrics[0]);
		$getlyrics = explode('<script type="text/javascript">', $getlyrics[1]);
		echo "<center><br><font size=60><b>$getname[1]</b></font><br><br>$getlyrics[0]</center>";
	}
}


?>