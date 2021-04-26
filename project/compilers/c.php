<?php
	$CC="gcc";
	$out="a";
	$code=$_POST["username"];
	$input=$_POST["pass"];
	$filename_code="main.c";
	$filename_in="input.txt";
	$filename_error="error.txt";
	$executable="a";
	$command=$CC." -lm ".$filename_code;	
	$command_error=$command." 2>".$filename_error;

	//if(trim($code)=="")
	//die("The code area is empty");
	
	$file_code=fopen($filename_code,"w+");
	fwrite($file_code,$code);
	fclose($file_code);
	$file_in=fopen($filename_in,"w+");
	fwrite($file_in,$input);
	fclose($file_in);
	exec("chmod 777 $executable"); 
	exec("chmod 777 $filename_error");	

	shell_exec($command_error);
	$error=file_get_contents($filename_error);

	if(trim($error)=="")
	{
		if(trim($input)=="")
		{
			$output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		$ans = $output;
	}
	else if(!strpos($error,"error"))
	{
		$ans = $error;
		if(trim($input)=="")
		{
			$output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		$ans = $output;
	}
	else
	{
		$ans = $error;
	}
	exec("rm $filename_code");
	exec("rm *.o");
	exec("rm *.txt");
	exec("rm $executable");
?>