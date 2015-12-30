<?php require_once('./contactDAO.php'); ?>
<?php include 'header.php'; ?>

            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>XXXX Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)XXX-XXXX</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)XXX-XXXX</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
					 <?php
					
					try{
						$contactDAO = new contactDAO();
						//Tracks errors with the form fields
						$hasError = false;
						//Array for our error messages
						$errorMessages = Array();

						//Ensure all four values are set.
						//They will only be set when the form is submitted.

					if(isset($_POST['customerName']) || isset($_POST['phoneNumber']) || isset($_POST['emailAddress']) || isset($_POST['referral'])){

						if($_POST['customerName'] == ""){
							$errorMessages['customerNameError'] = 'Please enter a customer name.';
							$hasError = true;
						}

						if(!is_numeric($_POST['phoneNumber']) || $_POST['phoneNumber'] == ""){
							$errorMessages['phoneNumberError'] = "Please enter a phone number.";
							$hasError = true;
						}

						if($_POST['emailAddress'] == ""){
							$errorMessages['emailAddressError'] = "Please enter a email address.";
							$hasError = true;
						}
						
						if(!$hasError){
							$contact = new ContactInfo("1", $_POST['customerName'], $_POST['phoneNumber'], $_POST['emailAddress'], $_POST['referral']);
							if ($contactDAO->dupEmail($contact->getEmail())){
								echo '<span style=\'color:red\'>This is a duplicate email, please change another email.</span>';
							}
							else{
								$addSuccess = $contactDAO->addContact($contact);
								echo '<h3>' . $addSuccess . '</h3>';
							}
						}
					}
					if(isset($_POST['btnSubmit'])){
						$target_path = "files/";
						$target_path = $target_path . basename( $_FILES['myfile']['name']);

						if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
							$fileUploaded = "The file ".  basename( $_FILES['myfile']['name']). " has been uploaded";
							echo "<p>$fileUploaded</p>";
						} else{
							echo "There was an error uploading the file, please try again!";
							}
						}								
					?>
					
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40'
								value = "<?php echo isset($_POST['customerName']) ? $_POST['customerName'] : ''?>">
								<?php 
									//If there was an error with the customer name field, display the message
									if(isset($errorMessages['customerNameError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['customerNameError'] . '</span>';
									}
								?></td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'
									value = "<?php echo isset($_POST['phoneNumber']) ? $_POST['phoneNumber']: ''?>">
								<?php 
									//If there was an error with the phone number field, display the message
									if(isset($errorMessages['phoneNumberError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['phoneNumberError'] . '</span>';
									}
								?></td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40'
									value = "<?php echo isset($_POST['emailAddress']) ? $_POST['emailAddress']: ''?>">
								<?php 
									//If there was an error with the email field, display the message
									if(isset($errorMessages['emailAddressError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['emailAddressError'] . '</span>';
									}
								?></td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper" checked>
                                    Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
                                    TV<input type='radio' name='referral' id='referralTV' value='TV'>
                                    Other<input type='radio' name='referral' id='referralOther' value='other'>
									<?php 
									//If there was an error with the referral field, display the message
									if(isset($errorMessages['referralError'])){
										echo '<span style=\'color:red\'>' . $errorMessages['referralError'] . '</span>';
									}
								?></td>
                            </tr>
							<tr>
								<td>Upload Attachment: </td>
								<td><input type="file" name="myfile" value=""></td>
							</tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>
                    </form>
					<?php
					} catch(Exception $e){
					//If there were any database connection/sql issues,
					//an error message will be displayed to the user.
					echo '<h3>Error on page.</h3>';
					echo '<p>' . $e->getMessage() . '</p>';  
					}
					?>
                </div><!-- End Main --> 
        </div><!-- End Content -->

<?php include 'footer.php'; ?>