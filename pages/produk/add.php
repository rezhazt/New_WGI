<?php
  include('../../connection.php');
  $upload_dir = '../../img/product/';

  if (isset($_POST['Submit'])) {
    $name = $_POST['name'];

    $imgName = $_FILES['image']['name'];
		$imgTmp = $_FILES['image']['tmp_name'];
		$imgSize = $_FILES['image']['size'];

    if(empty($name)){
			$errorMsg = 'Please input product name';
	
		}else{

			$imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

			$allowExt  = array('jpg');

			$userPic = time().'_'.rand(1000,9999).'.'.$imgExt;

			if(in_array($imgExt, $allowExt)){

				if($imgSize < 50000){
					move_uploaded_file($imgTmp ,$upload_dir.$userPic);
				}else{
					$errorMsg = 'Ukuran foto terlalu besar, maks 5M';
				}
			}else{
				$errorMsg = 'tipe file salah, masukkan type file ".JPG"';
			}
		}


		if(!isset($errorMsg)){
			$sql = "insert into tabel_produk(name,  image)
					values('".$name."', '".$userPic."')";
			$result = mysqli_query($kon, $sql);
			if($result){
				$successMsg = 'Produk sudah ditambahkani';
				header('Location: produk.php');
			}else{
				$errorMsg = 'Error '.mysqli_error($kon);
			}
		}
	}
?>