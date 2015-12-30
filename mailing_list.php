<?php require_once('WebsiteUser.php'); 
	require_once('./contactDAO.php'); 
  include 'header.php'; 
  session_start();
	session_regenerate_id(false);?>

<div id="content" class="clearfix">
  <?php
		$websiteUser = new WebsiteUser();
		echo 'Session ID: ' . session_id() . '<br>';
		echo 'Admin ID: ' . $websiteUser->getInfo($_SESSION['username'], $_SESSION['password'])[0] . '<br>';
		echo 'Last Login: ' . $websiteUser->getInfo($_SESSION['username'], $_SESSION['password'])[1] . '<br>';
        //This section will display an HTML table containing all
        //the customer in the mailingList table. 
        //
		$contactDAO = new contactDAO();
        $mailingList = $contactDAO->getContacts();
		if($mailingList){
			//We only want to output the table if we have customer.
			//If there are none, this code will not run.
			echo '<div id="contactInfo">';
			echo '<table border=\'1\'>';
			echo '<tr><th>Customer ID</th><th>Name</th><th>Phone Number</th><th>Email</th><th>Referral</tr>';
			foreach($mailingList as $contact){
				echo '<tr>' ;
				echo '<td>' . $contact->getId() . '</td>';
				echo '<td>' . $contact->getName() . '</td>';
				echo '<td>' . $contact->getphone() . '</td>';
				echo '<td>' . $contact->getEmail() . '</td>';
				echo '<td>' . $contact->getRefer() . '</td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '</div>';
			
		}
    ?>
	<form name="login" id="login" method="get" action="logout.php">
		<input type="submit" name="submit" id="submit" value="Logout">
	</form>
</div><!-- End Content -->

<?php include 'footer.php'; ?>