<?php
error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';
$error = 0;
$assets_path = '../assets/images';
if (version_compare(PHP_VERSION, '7.0.0', '<') || version_compare(PHP_VERSION, '8.0.0', '>')) {
    die('<p class="error">You need PHP version 7.x to run this application. Your PHP version: ' . PHP_VERSION . '</p>');
}
$module =  in_array('mod_rewrite', apache_get_modules());

if($module == 1){?>

<?php $error = 1; ?>
<?php }else{?>
	<?php $error = 0; ?>
	<p class="error">Please enable mod_rewrite. <strong>Example</strong>:<br /><br /><code>a2enmod rewrite</code></p>

<?php }

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      $redir .= "://".$_SERVER['HTTP_HOST'];
      $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      $redir = str_replace('install/','',$redir); 
			//header( 'Location: ' . $redir . 'login' ) ;
			header( 'Location: ' . $redir) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Install | MedJacket</title>

		<style type="text/css">
		  body {
		    font-size: 75%;
		    font-family: Helvetica,Arial,sans-serif;
		    width: 300px;
		    margin: 0 auto;
		  }
		  input, label {
		    display: block;
		    font-size: 18px;
		    margin: 0;
		    padding: 10px;
		    border-radius:10px;
		  }
		  label {
		    margin-top: 20px;
		  }
		  input.input_text {
		    width: 270px;
		  }
		  input#submit {
		    margin: 25px auto 0;
		    font-size: 25px;
		  }
		  fieldset {
		    padding: 15px;
		    border-radius:10px;
		  }
		  legend {
		    font-size: 18px;
		    font-weight: bold;
		  }
		  .error {
		    background: #ffd1d1;
		    border: 1px solid #ff5858;
        padding: 4px;
		  }
		</style>
	</head>
	<body>

    <center><img src="../assets/images/login-logo.png" alt="Home" height="100"><h1>Installation</h1></center>
    <?php if(is_writable($db_config_path) && is_writable($assets_path) ){?>
		<?php $error = 1; ?>
		  <?php if(isset($message)) {echo '<p class="error">' . $message . '</p>';}?>

		  <form id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
          <legend>Database settings</legend>
          <label for="hostname">Hostname</label><input type="text" id="hostname" value="localhost" class="input_text" name="hostname" />
          <label for="username">Username</label><input type="text" id="username" class="input_text" name="username" />
          <label for="password">Password</label><input type="password" id="password" class="input_text" name="password" />
          <label for="database">Database Name</label><input type="text" id="database" class="input_text" name="database" />
          <?php if($error == 1) { ?><input type="submit" value="Install" name="SubmitButton" id="submit" /> <?php } ?>
        </fieldset>
		  </form>

	  <?php } else { ?>
		<?php $error = 0; ?>
      <p class="error">Please make sure the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
	  <p class="error">Please make sure the assets/images folder writable. <strong>Example</strong>:<br /><br /><code>chmod 777 assets/images</code></p>
	  <?php } ?> 
	 
	  <?php 
	  $cloneDirectory = dirname(__FILE__);
	  function createDatabase($dbHost, $dbUser, $dbPass, $dbName)
	  {
		  $connection = new mysqli($dbHost, $dbUser, $dbPass);
		  if ($connection->connect_error) {
			  return "Connection failed: " . $connection->connect_error;
		  }
		  $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
		  if ($connection->query($sql) === TRUE) {
			  return "Database $dbName created successfully.";
		  } else {
			  return "Error creating database: " . $connection->error;
		  }
	  }
	  
	  function importDatabase($dbHost, $dbUser, $dbPass, $dbName, $sqlFile)
	  {
		  $connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
		  if (!$connection) {
			  die("Connection failed: " . mysqli_connect_error());
		  }
		  $handle = fopen($sqlFile, "r+");
		  if ($handle) {
			  $contents = fread($handle, filesize($sqlFile));
			  fclose($handle);
			  $sqlQueries = explode(";", $contents);
			  
			  foreach ($sqlQueries as $query) {
				  $query = trim($query);
				  if (!empty($query)) {
					  $result = mysqli_query($connection, $query);
	
				  }
			  }
		  } else {
			  echo "Error opening the file.";
		  }
		  mysqli_close($connection);
	  }
	  
	  if(isset($_POST['SubmitButton'])){
	  $dbHost = $_POST['hostname'];
	  $dbUser = $_POST['username'];
	  $dbPass = $_POST['password'];
	  $dbName = $_POST['database'];
 
	  $newcloneDirectory =  str_replace("install","",$cloneDirectory);
	  $sqlFile = $newcloneDirectory . "dump/med_pharma.sql";
	  $dbCreationOutput = createDatabase($dbHost, $dbUser, $dbPass, $dbName);
	  echo "<pre>Database Creation Output:\n$dbCreationOutput</pre>";
	  
	  $importOutput = importDatabase($dbHost, $dbUser, $dbPass, $dbName, $sqlFile);
	  echo "<pre>Database Import Output:\n$importOutput</pre>";
	  }
 ?>
	  

	</body>
</html>
