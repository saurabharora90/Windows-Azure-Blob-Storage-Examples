<?php

/*
The How to use the Blob service from PHP guide at http://www.windowsazure.com/en-us/develop/php/how-to-guides/blob-service/
shows you how to perform basic operation with the Blob storage service using the Azure SDK for PHP. It shows you how to
Upload a Blob into a container but that method is suitable only for small files. Though you can upload a Blob of 64MB using
that implementaion, one would mostly like to upload such big files in some small chunks and then join them. Also, sometimes,
we need to upload media more than 64MB.

In this example, I will show you how to connect to the blob storage service and upload a large file to the Blob Storage and uploading
it in chunks (by using the Put Block method) and then combining the chunks using the Put Block List method.
*/

//Assuming you had a form which allows you to upload multiple files in one go and the following will be called script will run to upload the file.

//Note: the HTML responsible for the file upload for this example is: <input type="file" name="file_up[]" multiple>
	
	require_once("WindowsAzure/WindowsAzure.php");
	use WindowsAzure\Common\ServicesBuilder;
	use WindowsAzure\Common\ServiceException;
	use WindowsAzure\Blob\Models\BlockList;
 
	$blobConnectionString="DefaultEndpointsProtocol=[http/https];AccountName=[Your_Account_Name];AccountKey=[Primary_Key]";
	$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($blobConnectionString);
	 for($i=0;$i<count($_FILES['file_up']['name']);$i++)
		 {
		  $blobName = $_FILES['file_up']['name'][$i];

		  $blockMaxSize = 4*1024*1024; //4MB you can upload a Block of max og 4MB in size.
		  $fileSize = $_FILES['file_up']['size'][$i];
		  $numOfBlocks = $fileSize/$blockMaxSize;
		  $currentFileIndex = 0;
		  $blockId=1;
		  $blocklist = new BlockList();
		  while($numOfBlocks>0)
		  {
			  $content = file_get_contents($_FILES['file_up']['tmp_name'][$i],NULL,NULL,$currentFileIndex,$blockMaxSize);
			  $currentFileIndex+=$blockMaxSize;
			  $numOfBlocks-=1; //Read the current block.

			  //upload the block
			  $blobRestProxy->createBlobBlock("imageuploads", $blobName, md5($blockId),$content);
			  $blocklist->addLatestEntry(md5($blockId)); //you need to maintain a list of all the blockIds that are a part of this blob
			  $blockId++;
		  }

		  $blobRestProxy->commitBlobBlocks("imageuploads", $blobName, $blocklist->getEntries()); //Merge all the blockIds to form the blob.
		  }

?>