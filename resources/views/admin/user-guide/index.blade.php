<x-app-layout>
<!-- {{--         <iframe name='mainFrame' id="mainFrame" class="w-100 h-full mainFrame" frameborder="0" noresize='noresize'
            scrolling='auto' src="{{ url('resources/docs/index.html') }}" class="mainFrame">
        </iframe> --}} -->
        <section class="font-1 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                        <div class="my-1"></div>
	                        <div class="row">
	                        	<div class="col-lg-3 hidden-md-down">
                          	  <div class="sticky-top pt-5 pl-1">
														    <h5 class="mb-1 fs-0" id="top">Introduction</h5>
														    <ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
														      <li class="nav-item">
														        <a href="#purpose" class="color-3 nav-link" title="Purpose">Purpose</a>
														      </li>
														      <li class="nav-item">
														        <a href="#scope" class="color-3 nav-link" title="Scope">Scope</a>
														      </li>
														      <li class="nav-item">
														        <a href="#symbol-keys" class="color-3 nav-link" title="Symbol Keys">Symbol Keys</a>
														      </li>
														    </ul>																		    																		    
														    <h5 class="mb-1 fs-0">Getting Started</h5>
														    <ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
														      <li class="nav-item">
														        <a href="#system-requirements" class="color-3 nav-link" title="System Requirements">System Requirements</a>
														      </li>
														      <li class="nav-item">
														        <a href="#login-and-password-security" class="color-3 nav-link" title="Login">Login</a>
														      </li>
														      <li class="nav-item">
														        <a href="#dashboard" class="color-3 nav-link" title="Dashboard">Dashboard</a>
														      </li>
														      <li class="nav-item">
														        <a href="#navigation-and-menus" class="color-3 nav-link" title="Navigation and Menus">Navigation and Menus</a>
														      </li>
														      <li class="nav-item">
														        <a href="#attachments"  class="color-3 nav-link" title="Attachments">Attachments</a>
														      </li>
														      <li class="nav-item">
														        <a href="#inmail" class="color-3 nav-link" title="InMail">InMail</a>
														      </li>
														      <li class="nav-item">
														        <a href="#esignature" class="color-3 nav-link" title="E-Signature">E-Signature</a>
														      </li>
														      <li class="nav-item">
														        <a href="#logs" class="color-3 nav-link" title="Logs">Logs</a>
														      </li>
														    </ul>
														    <h5 class="mb-1 fs-0" id="#top">Insureds</h5>
														    <ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
														      <li class="nav-item">
														        <a href="#insured" class="color-3 nav-link" title="Insureds">Insureds</a>
														      </li>
														      <li class="nav-item">
														        <a href="#add-insured" class="color-3 nav-link" title="Add Insured">Add Insured</a>
														      </li>
														      <li class="nav-item">
														        <a href="#find-insured" class="color-3 nav-link" title="Find Insured">Find Insured</a>
														      </li>
														    </ul>		
														    <h5 class="mb-1 fs-0" id="#top">Quotes</h5>
														    <ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
														      <li class="nav-item">
														        <a href="#quotes" class="color-3 nav-link" title="Quotes">Quotes</a>
														      </li>
														      <li class="nav-item">
														        <a href="#add-quote" class="color-3 nav-link" title="Add Quotes">Add Quote</a>
														      </li>
														      <li class="nav-item">
														        <a href="#find-quote" class="color-3 nav-link" title="Find Quote">Find Quote</a>
														      </li>
														      <li class="nav-item">
														        <a href="#request-quote-activiation" class="color-3 nav-link" title="Request Quote Activiation">Request Quote Activiation</a>
														      </li>														      
														    </ul>	
														    <h5 class="mb-1 fs-0" id="#top">Accounts</h5>
														    <ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
														      <li class="nav-item">
														        <a href="#accounts" class="color-3 nav-link" title="Accounts">Accounts</a>
														      </li>
														      <li class="nav-item">
														        <a href="#find-account" class="color-3 nav-link" title="Find Account">Find Account</a>
														      </li>
														      <li class="nav-item">
														        <a href="#add-endorsement" class="color-3 nav-link" title="Add Endorsement">Add Endorsement</a>
														      </li>														      
														    </ul>	
														     <h5 class="mb-1 fs-0" id="#top"><a class="color-3" href="#terms-and-definitions" title="Terms & Definitions">Terms & Definitions</a></h5>														    	
	                              </div>
	                            </div>
	                            <!-- Content -->
					                    <div class="col-lg-8 pt-5">
					                    	<h4 class="mb-2">Welcome!</h4>
					                    	<p>As an Agent/Broker you can produce quotes, view your insureds loans, add Additional Premiums, and make payement on behalf of your insureds.</p>
					                    		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
															<section id="purpose">
																<h4 class="mt-5 mb-2">Purpose</h4>
																<p>The purpose of this document is to provide a comprehensive User Guide to premium finance companies users and site configuration to admnsitrators on the LMS Premium Finance system.</p>
															<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
															</section>
															<section id="scope">
																<h4 class="mt-5 mb-2">Scope</h4>
																<p>The scope of this document is limited to providing the steps or details on how-to use the system. It will not provide details on the business rules that are specific to each Finance Company and/or Agency. The hands-on training workshop will be able to provide more on the specifics of the business rules and functions that are executed and realised by the system.</p>
																<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
															</section>
															<section id="symbol-keys">
																<h4  class="mt-5 mb-2">Symbol Keys</h4>
																<p>Look for the symbols below to find hints and important information.</p>
																<p>
																 <i class="fa-regular fa-circle-exclamation alert-danger"></i> Important steps that affect software functionality.<br>
																 <i class="fa-regular fa-circle-info alert-info"></i> Notes that offer additional information		
																 </p>
																 <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
															</section>																		                    	
					                      <section id="system-requirements">
					                         <h4 class="mt-5 mb-2">System Requirements</h4>
					                         <p>enetworks's LMS is Software as a service (Saas). Software as a service (SaaS) allows users to connect to and use cloud-based apps over the Internet. Users can access LMS directly from their web browser without needing to download and install any software.</p>
					                         <p>LMS supports many browsers, however we recommand using one of the following browsers..</p>
					                         <ul>
					                            <li>Google Chrome</li>
					                            <li>Firefox</li>
					                            <li>Microsoft Edge</li>
					                            <li>Opera</li>
					                         </ul>
					                         <div class="alert alert-info">
					                            <i class="mr-3 fa-regular fa-circle-info"></i>  LMS <b>DOES NOT SUPPORT</b> Microsoft Internet Explorer.
					                         </div>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="login-and-password-security">
					                         <h4  class="mt-5 mb-2">Login</h4>
					                         <p>From your desktop or mobile device, open a browser such as Google Chrome, and type in the URL as given to you to access the Login page.</p>
					                         <p>Login Page can be also found at <kbd>gotpremiums.com</kbd> <b>&gt;</b> <kbd>Navigation Menu</kbd> <b>&gt;</b> <kbd>Login</kbd> <b>&gt;</b> <kbd>LMS</kbd></p>
					                         <h4>Password &amp; Login Security</h4>
					                         <p>Keep your account more secure by changing your password regularly. It only takes a few steps.</p>
					                         <p>Go to the <kbd>Navigation Main Menu</kbd> <b>&gt;</b> <kbd>My Profile</kbd> <b>&gt;</b> <kbd>Action Menu</kbd> <b>&gt;</b> <kbd>Edit</kbd></p>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="dashboard">
					                         <h4  class="mt-5 mb-2">Dashboard</h4>
					                         <p>As soon as an Agent/Broker User is login, the Agent/Broker Users will be brought over to a Dashboard.</p>
					                         <p>The Dashboard provides at-a-glance views of key performance indicators .i.e. Open Quotes, Active Accounts, Draft Quotes, Insureds as well links to common tasks.</p>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="navigation-and-menus">
					                         <h4  class="mt-5 mb-2">Navigation and Menus</h4>
					                         <p>Navigation uses menus with internal links that make it easy for Users to find the page that they are looking for. LMS has 3 types of Menus.</p>
					                         <h5>Navigation Main Menu</h5>
					                         <p>The Navigation Main Menu is an horizontal bar that can be found on every page. With the Main Navigation Menu, Agents/Brokers Users are able to navigate through regardless of where they are in the system.</p>
					                         <h5>Sub-Menu</h5>
					                         <p><b>Sub-Menus</b> aka <b>Drop Down Menus</b> can be found under the Page Title. <b>Sub-Menu</b> list additional actions that are avaialble for Users.</p>
					                         <h5>Action Menu</h5>
					                         <p>Regardless of where a Users are in the system they will also find an <b>Action Menu</b> <i class="fa-light fa-ellipsis-stroke fa-fw fa-sm fw-600"></i>. <!--b>Action Menu</b> are to the right at table row. With the <b>Action Menu</b> Users can <b>View</b>, <b>Edit</b>, <b>Delete</b> enteries.</p -->
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="attachments">
					                         <h4  class="mt-5 mb-2">Attachements</h4>
					                         <p>LMS provides Agents/Brokers with the ability to Attach electronic documents to the Insured Profile, Quote, Policies, and InMails.</p>
					                         <p>Attachements can be in a form of PDF, Word, Text, and other scanned images.</p>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="inmail">
					                         <h4  class="mt-5 mb-2">InMail</h4>
					                         <p><b>InMail</b> is a credible, private, and customized messaging tool helping Agents/Brokers to comminucate with Premium Finance Company Users, Agency Users, and Insured Users.</p>
					                         <p>When sending an <b>InMail</b>, Recipient of InMails are being notified via E-Mail and at the Main Navigation Menu.</p>			                         
					                         <div class="alert alert-info">
					                            <i class="mr-3 fa-regular fa-circle-info"></i>  Agency Users need to have their <b>Use InMail Service settings</b> to <b>Yes</b> to be able to use InMail.
					                         </div>
					                         <p>There are many ways to send an InMail.</p>
					                          <ul style="list-style-type:none">
					                         	 <h5>Using InMail within a Quote.</h5>
					                         		<li>
					                         			<p>To Compose an InMail from within a Quote..</p>
					                         		</li>
					                          </ul>
					                          <ul style="list-style-position: inside;">  
					                            <li>Open a Quote.</li>
					                            <li>Click on InMail</li>
					                            <li>Click on <b><u>New InMail</u></b></li>
					                            <li>Find the the LABELS (on the left), and select the proper Label.</li>
					                            <ul>
					                               <li>Finance Company Users are in Green</li>
					                               <li>Insured Usres are in Red</li>
					                               <li>Agency Users are in Blue</li>
					                            </ul>
					                            <li>Click the To Field and select the person you wish to send the InMail to</li>
					                            <li>Click the CC (Carbon Copy) if you wish to include others in the InMail</li>
					                            <li>Go to Subject Field, and enter any Subject text that you wish to Add</li>
					                         </ul>
					                        <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="esignature">
					                         <h4  class="mt-5 mb-2">E-Signature</h4>
					                         <p>An e-signature or electronic signature is a legal way to get consent or approval on electronic documents or forms. It can replace a handwritten signature ("Wet" signature) in virtually any process. An e-signature or electronic signature is a legal way to get consent or approval on electronic documents or forms.</p>
					                         <p>To streamline the Finace Agreement sigantures, LMS is using an E-Signature feature that is avalaible to Agents/Brokers at no cost.</p>
					                         <div class="alert alert-info">
					                            <i class="mr-3 fa-regular fa-circle-info"></i> An insured email is required when using e-signature in LMS.
					                         </div>
					                         <ul style="list-style-type:none">
						                         <h5  class="mt-5 mb-2">Signing Order</h5>
						                         <li>
						                       		 <p>The order in which e-signature recipients are allowed to sign. For example, if the Agent signs first and the Insured signs second, the Insured will not be allowed to sign until the Agent has finished signing.</p>
						                         </li>
						                        	<div class="alert alert-info">
						                            <i class="mr-3 fa-regular fa-circle-info"></i> Agents are the first to e-signature a Finance Agreement.
						                         </div>
					                         </ul>
					                          <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="logs">
					                         <h4  class="mt-5 mb-2">Logs</h4>
					                         <p>
					                         	<b>Logs</b> are automatically generated as a result of transactions made in the system, such as, changing Insured contact information, Recording a payment, Adding/Deleting/Changing a Policy, Attaching Docuemnts, etc..
					                         </p>
					                         <p><b>Logs</b> provide historical visibility into activity, so changes won't go overlooked.</p>
					                         <p>For these reasons, the <b>Logs</b> can not be Deleted and can be Viewed regardless of where a Users is in the system.</p>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="insured">
					                         <h4  class="mt-5 mb-2">Insured</h4>
					                         <p><b>Insured</b> is an individual or entity that is covered by an insurance policy</p>
					                         <p>Insureds can be Added when creating a Quote or at the Main Navigation Menu > Entity > Insured.</p>
					                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                      </section>
					                      <section id="add-insured">
					                         <h4  class="mt-5 mb-2">Add Insured</h4>   
					                         <p>There are two ways to Add an Insured in the system. Fileds that marked with <span style="color: #FF3B30;">*</span> are required fields.</p>
					                          <ul style="list-style-type:none">
					                         	 <h5>Add an Insured from Entity Manager</h5>
					                          </ul>
					                          <ul style="list-style-position: inside;">  
					                            <li>Go to the <b>Navigation Main Menu > Entity Manager > Insureds</b></li>
																			<li>Click on <b>Add Insured</b></li>
																					<li>Enter the <b>Named Insured</b> <span style="color: #FF3B30;">*</span> as it should appear on the Finance Agreement</li>
																					<li>Insured <b>Contact Name</b> <span style="color: #FF3B30;">*</span> (First Name, M/I, Last Name)</li>
																					<li>Enter <b>Telephone</b> number <span style="color: #FF3B30;">*</span> and Extention. (Extension is not a required field)</li>
																					<li>Fax</li>
																					<li>Email</li>
																						<ul class="alert alert-info" style="list-style-type:none;">
																							<li>
																								<i class="mr-3 fa-light fa-circle-info"></i> If an email address is provided, the system can send a courtesy notice to the insured when the payment is late.
																							</li>
																						</ul>
																					<li>Enter the Insured <b>Title</b></li>
																					<li>Select the <b>Date of Birth</b> MM/DD</li>
																					<li>Enter <b>Physical/Risk Address</b> <span style="color: #FF3B30;">*</span></li>	
																					<li>Mailing Address. Mailing Address is <b>required</b> when the Mailing Address is not the same as the Physical/Risk Address</li>
																					<li>Check Decline Reinstatement if Payment Received After Cancellation</li>
																					<ul class="alert alert-info" style="list-style-type:none;">
																						<li>
																							<i class="mr-3 fa-light fa-circle-info"></i> Determines whether or not to decline reinstatement automatically if a payment is received after cancellation for the insured's accounts. <b><u>No</u></b> is checked by default.
																						</li>
																					</ul>
																					<li>Insured Login (Enable/Disable)</li>
																					<li>Email Notifcation</li>
																						<ul class="alert alert-warning" style="list-style-type:none;">
																							<li>
																								<i class="mr-3 fa-light fa-circle-info"></i> Only one Insured Contact will receive all Notices. By default it is the <b>Insured Contact Name</b>
																							</li>
																						</ul>
																					<li>Notes. These are Insured Notes that are only visiable to the Agency Users</li>
																					<li>Click the <b>Save</b> button.</li>
																				</ul>
					                        	<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
					                          <ul style="list-style-type:none">
					                         	 <h5>Add an Insured from Quotes</h5>
					                          </ul>
					                          <ul style="list-style-position: inside;">  
					                            <li>Go to the <b>Navigation Main Menu > Quotes > New Quote</b></li>
																			<li>Type the Insured Name</li>
																				<ul class="alert alert-danger" style="list-style-type:none;">
																					<li>
																						<i class="mr-3 fa-light fa-circle-info"></i> If no Insured is found matching the Insured Name a <b>No matching records were found. You can create new insured by <u>clicking here</u>.</b> will apper.
																					</li>
																				</ul>	
																				<li>Click on the <b><u>clicking here</u></b> link</li>																		
																					<li>Enter the <b>Named Insured</b> <span style="color: #FF3B30;">*</span> as it should appear on the Finance Agreement</li>
																					<li>Insured <b>Contact Name</b> <span style="color: #FF3B30;">*</span> (First Name, M/I, Last Name)</li>
																					<li>Enter <b>Telephone</b> number <span style="color: #FF3B30;">*</span> and Extention. (Extension is not a required field)</li>
																					<li>Fax</li>
																					<li>Email</li>
																						<ul class="alert alert-info" style="list-style-type:none;">
																							<li>
																								<i class="mr-3 fa-light fa-circle-info"></i> If an email address is provided, the system can send a courtesy notice to the insured when the payment is late.
																							</li>
																						</ul>
																					<li>Enter the Insured <b>Title</b></li>
																					<li>Select the <b>Date of Birth</b> MM/DD</li>
																					<li>Enter <b>Physical/Risk Address</b> <span style="color: #FF3B30;">*</span></li>	
																					<li>Mailing Address. Mailing Address is <b>required</b> when the Mailing Address is not the same as the Physical/Risk Address</li>
																				
																					<li>Check Decline Reinstatement if Payment Received After Cancellation</li>
																					<ul class="alert alert-info" style="list-style-type:none;">
																						<li>
																							<i class="mr-3 fa-light fa-circle-info"></i> Determines whether or not to decline reinstatement automatically if a payment is received after cancellation for the insured's accounts. <b><u>No</u></b> is checked by default.
																						</li>
																					</ul>
																					<li>Insured Login (Enable/Disable)</li>
																					<li>Email Notifcation</li>
																						<ul class="alert alert-warning" style="list-style-type:none;">
																							<li>
																								<i class="mr-3 fa-light fa-circle-info"></i> Only one Insured Contact will receive all Notices. By default it is the <b>Insured Contact Name</b>
																							</li>
																						</ul>
																					<li>Notes. These are Insured Notes that are only visiable to the Agency Users</li>
																					<li>Click the <b>Save</b> button.</li>
																					<li>Click the <b>Enter Quote</b> button or the <b>Exit</b> button.</li>
																				</ul>
							                        <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
							                      </section>	
							                      <section id="find-insured">
							                         <h4  class="mt-5 mb-2">Find Insured</h4>
							                         <p>Follow the steps below to Find an Insured</p>
							                        <ul>
							                        	<li>Go to the <b>Navigation Main Menu</b></li>
							                        	<li>Click on <b>Entity Manager > Insureds</b></li>
							                        	<li>At the <b>Table View</b> type the Insured Name at <b>Search</b></li>
							                        </ul>		                         
							                         <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
							                      </section>	
							                      <section id="quotes">   
								                    	<h4 class="mt-5 mb-2">Quotes</h4>
								                    	<p>As an Agent/Broker you can produce quotes.</p>
								                    	<h5>Quote Versions and Favorite</h5>
								                    	<p>When adding a new Qoute, LMS assign a Quote Version along with a Quote Number. For example, the first time a User create a Quote LMS will assign the Quote Number as #######.1. The next Quote Version will be #######.2.</p>
								                    	<p>When having multiple <b>Quote Version</b>s under a single Quotes, a User must select the <b>Quote Version</b> prior to <b>Request for Activation</b>. Selecting the <b>Quote Version</b> is accomplished by <b>Favorite</b> the <b>Quote Version</b>. The <b>Favorite</b> is icon is <i class="fa-solid fa-star" style="color: orange;"></i>.</p>
								                    		<div class="alert alert-info">
							                            <i class="mr-3 fa-regular fa-circle-info"></i> A User may change Favorite Version by toggle the Favorite icon and/or Favorite Link.  
							                         </div>
							                        <h5>The Quote Page</h5>
							                        <p>From the Quote screen, User are able to create a New Quote, Edit Quote, Save Quote, Print Finance Agreement, and E-Signature Quote to Insureds.</p>
							                        <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
								                   </section>
																		<section id="add-quote">
																			<h4 class="mt-5 mb-2">Add Quote</h4>
																			<p>Quotes are often created by Agents/Brokers, but can be created by Finance Company Users when requested by an Agent/Broker as well.</p>
																			<p>There are few ways to Add a Quote in the system.</p>
																			<h5>Add Quote from Insured Profile</h5>
																			<p>Follow the steps below to Add a Quote from Insured Profile. Fields marked with <span style="color: #FF3B30;">*</span> are required fields.</p>
																			<ul>
																				<li>Go to the <b>Navigation Main Menu > Entity Manager > Insureds</b></li>
																				<li>Find the Insured</li>
																				<li>Click on the Insured Name</li>
																				<li>Click on Add Quote</li>
																			</ul>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		<section id="find-quote">
																			<h4 class="mt-5 mb-2">Find Quote</h4>
																			<p>The scope of this document is limited to providing the steps or details on how-to use the system. It will not provide details on the business rules that are specific to each Finance Company and/or Agency. The hands-on training workshop will be able to provide more on the specifics of the business rules and functions that are executed and realised by the system.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		<section id="request-quote-activiation">
																			<h4 class="mt-5 mb-2">Request Quote Activiation</h4>
																			<p>Look for the symbols below to find hints and important information.</p>
																			<p>
																			 <i class="fa-regular fa-circle-exclamation alert-danger"></i> Important steps that affect software functionality.<br>
																			 <i class="fa-regular fa-circle-info alert-info"></i> Notes that offer additional information		
																			 </p>
																			 <p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
								                      <section id="accounts">   								                         			                      				                      					           
								                    	<h4 class="mt-5 mb-2">Accounts</h4>
								                    	<p>As an Agent/Broker you can produce quotes, view your insureds loans, add Additional Premiums, and make payement on behalf of your insureds.</p>
								                    	<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
									                    </section>						                    	
																		<section id="find-account">
																			<h4 class="mt-5 mb-2">Find Account</h4>
																			<p>The purpose of this document is to provide a comprehensive User Guide to premium finance companies users and site configuration to admnsitrators on the LMS Premium Finance system.</p>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		<section id="add-endorsement">
																			<h4 class="mt-5 mb-2">Add Endorsement</h4>
																			<p>The scope of this document is limited to providing the steps or details on how-to use the system. It will not provide details on the business rules that are specific to each Finance Company and/or Agency. The hands-on training workshop will be able to provide more on the specifics of the business rules and functions that are executed and realised by the system.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		<section id="terms-and-definitions">
																			<h4 class="mt-5 mb-2">Terms & Definitions</h4>
																			<p>The following is a list of terms and definitions of the property and casualty insurance as well as the insurance premium finance industry.</p>
																			<ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href=<ul class="no-style fs--1 lh-1 pl-0" id="nav-elements">
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#tin">TIN</a>
																				</li>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href=""#t_and_d_insured">Insured</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_agency">Agency</a> 
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_non-resident_license">Non-Resident License</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_domicile_state">Domicile State</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_dl_issuance_state">DL/ID Issuance State</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_b_a">d/b/a</a> 
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_inception_date">Inception Date</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_puc_filing">PUC Filing</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_auditable">Auditable</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_short_rate">Short Rate</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_policy_term">Policy Term</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_autopay">AutoPay</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_account_current">Account Current</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_account_receivable">Account Receivable</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_actuarial_earning">Actuarial Earning</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_add-on_rate">Add-On Rate</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_agency_bill">Agency Bill</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_agent">Agent</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_independent_agents">Independent Agents</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_captive_agents">Captive Agents</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_effective_date">Effective Date</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_aging">Aging</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_amount_financed">Amount Financed</a> 
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_annual_percentage_rate_(apr)">Annual Percentage Rate (APR)</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_broker">Broker</a> 
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_broker-agent">Broker-Agent</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_cancellation">Cancellation</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_disclosure_statement">Disclosure Statement</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_down_payment">Down Payment</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_earned_premium">Earned Premium</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_finance_charge">Finance Charge</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_flat_cancellation">Flat Cancellation</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_general_agent">General Agent</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_insurance_policy">Insurance Policy</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_late_charge">Late Charge</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_late_notice">Late Notice</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_lender">Lender</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_loan">Loan</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_net_premium">Net Premium</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_net_premium_earned">Net Premium Earned</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_notice_of_cancellation">Notice of Cancellation</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_notice_of_intent_to_cancel">Notice of Intent to Cancel</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_notice_of_reinstatment">Notice of Reinstatment</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_premium">Premium</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_premium_finance_agreement">Premium Finance Agreement</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_regulation_z">Regulation Z</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_rule_of_78">Rule of 78</a>
																				</li>
																				<li class="nav-item">
																					<a class="color-1 fw-500 nav-link" href="#t_and_d_unearned_premium">Unearned Premium</a>
																				</li>
																			</ul>
																		</section>
																		<p>
					                         	<a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a>
					                          </p>																		
																	     <!--  --> 
																		<section id="t_and_d_tin">
																			<h4 class="mt-5 mb-2">TIN</h4>
																		<p>TIN, Taxpayer Identification Number, is an identification number used by the Internal Revenue Service (IRS). A TIN can be a Social Security Number (SSN) or Employer Identification Number (EIN)</p>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		<section id="t_and_d_insured">
																			<h4 class="mt-5 mb-2">Insured</h4>
																			<p>The official name of the person or entity that owns a business. If the Insured is the only owner of your business with no d/b/a, then its legal name is simply your full name. For limited partnerships, LLCs, and corporations, the legal name of the business is the name registered with the state filing office.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_agency">
																			<h4 class="mt-5 mb-2">State Resident</h4>
																			<p>State resident is the state that an agency hold its primary insurance license principal place of business</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_non-resident_license">
																			<h4 class="mt-5 mb-2">Non-State Resident</h4>
																			<p>An agent or an agency that is licensed in a state in which he or she don'ot reside.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_domicile_state">
																			<h4 class="mt-5 mb-2">Domicile State</h4>
																			<p>The state in which your Entity is registered, the place where your Entity principal affairs of business is maintained.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_dl_issuance_state">
																			<h4 class="mt-5 mb-2">DL/ID Issuance State</h4>
																			<p>The state in which your Identification Card (ID Card) or Drivers license (DL) was issued.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_d_b_a">
																			<h4 class="mt-5 mb-2">d/b/a</h4>
																			<p>The Insured company operating name, doing business as, as opposed to the legal name of the company. A company is said to be doing business as when the name under which they operate their business differs from its legal, registered name</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_inception_date">
																			<h4 class="mt-5 mb-4" id="t_and_d_inception_date">Inception Date</h4>
																			<p>The date an insurance policy coverage is started. Also called effective date.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_puc_filing">
																			<h4 class="mt-5 mb-2">PUC Filing</h4>
																			<p>Applies to all motor carrier mandatory filings to obtain or maintain a PUC certificates or permits.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_auditable">
																			<h4 class="mt-5 mb-2">Auditable</h4>
																			<p>Auditable insurance policies means the premium listed on the quote/policy is estimated and won't be finalized until an audit is performed at the end of the term by the carrier. If you are not sure ask your underwriter.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_short_rate">
																			<h4 class="mt-5 mb-2">Short Rate</h4>
																			<p>Is a means of determining what portion of a policy has been earned (or unearned), usually for the purpose of cancellation or computation of endorsements. There are several ways of determining a short rate calculation, but typically is determined by dividing the number of days the policy was in effect by the number of days in the policy period (typically 365 days) and adding an additional 10% penalty. Thus a $1,000 policy in effect for 163 days would have earned 163/365 (44.6% plus 10% = 54.6%) or $546. The insured would receive the reciprocal of that number, 45.4%, or $454. Short rate is normally used when the insured has cancelled the policy, or in many states, when the premium finance company has cancelled the policy for non-payment. Many states construe cancellation for non-payment a voluntary cancellation by the insured and thus eligible for short rate.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_policy_term">
																			<h4 class="mt-5 mb-2">Policy Term</h4>
																			<p>The period of time that an insurance policy provides coverage. Most policies have a one-year term (365 days) but many other policies also have a 6-month term. Policy terms can be for any length of time and can be for a short period when the period of risk is also short. Policy terms can also be for a multi-year period.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_autopay">
																			<h4 class="mt-5 mb-2">AutoPay</h4>
																			<p>AutoPay is a service that automatically deducts payments from insured's credit card or checking account to pay the monthly installments.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_account_current">
																			<h4 class="mt-5 mb-2">Account Current</h4>
																			<p>The means by which an agent settles his accounts with the insurance company each month, based upon a statement that includes all debits and credits. Account current allows agents and insureds to pay the net due, or request a check if the net is a credit (money owed the insured). Balances due are usually due at the end of the month following the month in which the business was written</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_account_receivable">
																			<h4 class="mt-5 mb-2">Accounts Receivable</h4>
																			<p>In premium finance, accounts receivable is an asset account comprised of the total of debit balances owed the premium finance company, whether current or not.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_actuarial_earning">
																			<h4 class="mt-5 mb-2">Actuarial Earning</h4>
																			<p>Actuarial earning is a means of earning interest on a financed contract. It is much more complicated than the Rule of 78 and requires sophisticated software to do it properly. In the premium finance context, it requires that interest be determined on a daily rate basis, much like a mortgage, then earned on the day that the next installment is paid.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_add-on_rate">
																			<h4 class="mt-5 mb-2">Add-on Rate</h4>
																			<p>n finance, it is a means to determine the appropriate finance charge for a given amount financed over a given term using rate tables. If the rate is known and the term is known, a table (<a href="#regulation_z">Regulation Z, Volume 1</a>) can be used to determine the dollar charge.</p>
																				<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_agency_bill">
																			<h4 class="mt-5 mb-2">Agency Bill</h4>
																			<p>A type of billing system for insurance policies in which the policy is purchased from an independent or captive agent, after which the bill appears on the agent's Account Current. The agent then contacts the insured and either collects the premium in cash or obtains a down payment and a signed premium finance agreement. The policy is subsequently paid on the following month's Agent Statement.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_agent">
																			<h4 class="mt-5 mb-2">Agent</h4>
																			<p>An individual appointed by an insurance company who receives a commission on the policies sold and serviced. Based upon compensation, agents work for insurance companies in one of two classifications.. Captive Agents or Independent Agent</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_independent_agents">
																			<h4 class="mt-5 mb-2">Independent Agents</h4>
																			<p>Independent agents represents at lease one insurance company and (at least in theory) services clients by searching the market for the most advantageous price for the most coverage. The agent's commission is a percentage of each premium paid.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_captive_agents">
																			<h4 class="mt-5 mb-2">Captive Agents</h4>
																			<p>Captive agents represent only one company and sells only its policies. This agent is paid on a commission basis in much the same manner as the independent agent.</p>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_effective_date">
																			<h4 class="mt-5 mb-2">Effective Date</h4>
																			<p>The date shown on the policy or binder when insurance coverage begins. This is also the date that interest begins to earn under the premium finance agreement, regardless of when funds are actually disbursed to the insurance company.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_aging">
																		<h4 class="mt-5 mb-2">Aging</h4>
																			<p>Aging Or "Aging Report", in premium finance, a report that separates all contracts in a portfolio of receivables into those that are "current", "30 days past due", "31-60 days past due", "61 to 90 days past due", "91 to 120 days past due", "121 to 150 days past due" and "151 to 180 days past due". Many states require any balance 181 days or more past due to be marked-off. The report is used to determine the effectiveness of the company's collection efforts.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_amount_financed">
																			<h4 class="mt-5 mb-2">Amount Financed</h4>
																			<p>In premium finance, the amount to be advanced by the premium finance company to the insurance company after the down payment has been deducted from the total premium.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_annual_percentage_rate_(apr)">
																			<h4 class="mt-5 mb-2">Annual Percentage Rate (APR)</h4>
																			<p>The cost of credit as computed as a percentage at a yearly rate. The APR can be used to compare the costs of different kinds of credit since it reduces interest rates to a common yearly rate, regardless of term.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_broker">
																			<h4 class="mt-5 mb-2">Broker</h4>
																			<p>Insurance salesperson who searches the marketplace in the interest of clients, not insurance companies. Not appointed by an insurance company and thus cannot bind coverage. Brokers are compensated through fees charged to the policyholder.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_broker-agent">
																			<h4 class="mt-5 mb-2">Broker-Agent</h4>
																			<p>Independent insurance salesperson who represents particular insurers but may also function as a broker by searching the entire insurance market to place an applicant's coverage to maximize protection and minimize cost. This person is licensed as an agent and broker by different companies (but not the same company).</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_cancellation">
																			<h4 class="mt-5 mb-2">Cancellation</h4>
																			<p>The process of terminating coverage under a policy of insurance. Cancellation may be requested by the insurer (in certain circumstances), the insured or by a lender for non-payment of premium if the policy is premium financed. See pro-rata and short rate for determination of earned and unearned premium.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_disclosure_statement">
																			<h4 class="mt-5 mb-2">Disclosure Statement</h4>
																			<p>The section of the premium finance agreement which illustrates the total premium, fees, amount financed, finance charge, annual percentage rate, total of payments and amount of each payment. Federal regulations require minimum type face size, bold letters and boxes to highlight this area for personal lines contracts only.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_down_payment">
																			<h4 class="mt-5 mb-2">Down Payment</h4>
																			<p>That portion of a policy collected by the agent to bind coverage and create a premium finance agreement. An adequate down payment will collect sufficient premium to cover the earned portion from inception date to the first payment due date plus enough time to cancel the policy.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_earned_premium">
																			<h4 class="mt-5 mb-2">Earned Premium</h4>
																			<p>That portion of a premium for which the policy protection has already been given during the now-expired portion of the policy term. Premium is earned on a daily basis, usually on a 12-month term except for automobile coverage which is typically written for a 6-month term.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_finance_charge">
																			<h4 class="mt-5 mb-2">Finance Charge</h4>
																			<p>In premium finance, the amount charged by the premium finance company for advancing the amount financed to the insurance company on behalf of the insured</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_flat_cancellation">
																			<h4 class="mt-5 mb-2">Flat Cancellation</h4>
																			<p>Cancellation of an insurance policy as of the effective date without charge. Commonly used to refer to rescinded premium finance agreements as well.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_general_agent">
																			<h4 class="mt-5 mb-2">General Agent</h4>
																			<p>The line between an agent and a General Agent is becoming more blurred, but a General Agent usually "holds the pen" for an insurance company, meaning the GA has underwriting and policy-writing authority. After that, the agency may or may not collect premiums, service the policy or settle claims.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_insurance_policy">
																			<h4 class="mt-5 mb-2">Insurance Policy</h4>
																			<p>The contract between insurer and insured containing information regarding the risk, policy holder, contractual conditions and rate assessed.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_late_charge">
																			<h4 class="mt-5 mb-2">Late Charge</h4>
																			<p>Also known as a Late Fee, it is an amount payable to the premium finance company, permitted by state statute, for any installment received more than 5 or 10 days after the due date (state statutes vary). Personal lines fees are usually limited to some nominal amount such as $5.00. Commercial lines usually consist of 5% of the installment amount. Late fees are posted as debits to the balance due from insured but are not earned as income until paid.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_late_notice">
																			<h4 class="mt-5 mb-2">Late Notice</h4>
																			<p>Usually the same notice as the Notice of Intent to Cancel, but can be a separate notice encouraging the policyholder to bring his premium finance agreement current. See Notice of Intent to Cancel.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_lender">
																			<h4 class="mt-5 mb-2">Lender</h4>
																			<p>A financial institution that loans money such as a bank, premium finance company or insurance company.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_loan">
																			<h4 class="mt-5 mb-2">Loan</h4>
																			<p>A sum of money which is lent for a specific period of time, repayable with interest and fees.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_net_premium">
																			<h4 class="mt-5 mb-2">Net Premium</h4>
																			<p>Is the portion of the premium for which the insurance company is responsible. It does not include the part of the premium that covers expenses, contingencies (commissions paid to agents) or profits. Why not profit? Because net premium is only potential profit at this point. The insurance company does not yet know whether or not it will be paid with this money.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_net_premium_earned">
																			<h4 class="mt-5 mb-2">Net Premium Earned</h4>
																			<p>This item represents the adjustment of the net premiums written for the increase or decrease during the year of the liability of the company for unearned premiums. When an insurance company's business is increasing in amount from year to year, the earned premiums will usually be less than the written premiums. With the increased volume, the premiums are considered fully paid at the inception of the policy so that at the end of a calendar period, the company must set up premiums representing the unexpired terms of the policies. On a decreasing volume, the reverse is true.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_notice_of_cancellation">
																			<h4 class="mt-5 mb-2">Notice of Cancellation</h4>
																			<p>A legal notice advising the policyholder that coverage is cancelled as of a certain date. It must be preceded by a Notice of Intent to Cancel for the cancellation to be legal. It can be sent by the insurance company for underwriting reasons. It can be sent by a premium finance company only for non-payment.</p>
																		</section>
																		<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		<section id="t_and_d_notice_of_intent_to_cancel">
																			<h4 class="mt-5 mb-4" id="t_and_d_notice_of_intent_to_cancel">Notice of Intent to Cancel</h4>
																			<p>A legal notice sent by a premium finance company (or insurance company) alerting the policyholder that the coverage will cease in ten to thirteen days (some states requires ten days plus mailing). Commonly called a "Late Notice" because most premium finance companies will wait for five or ten days (depending on state statutes) after the payment due date in order to charge a late fee</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_notice_of_reinstatment">
																			<h4 class="mt-5 mb-2">Notice of Reinstatment</h4>
																			<p>A form used when an insurance policy has been cancelled for non-payment by a premium finance company then brought current by the policyholder. This notice advises the policyholder that a request has been sent to the insurance company to reinstate the insurance policy. Only the insurance company can reinstate a cancelled insurance policy. The premium finance company cannot do so.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_premium">
																			<h4 class="mt-5 mb-2">Premium</h4>
																			<p>Is the cost of insurance coverage assessed by the insurer to the insured for coverage for a specified period. Also, the payment or one of the regular periodical payments a policyholder is required to make for an insurance policy.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_premium_finance_agreement">
																			<h4 class="mt-5 mb-2">Premium Finance Agreement</h4>
																			<p>The contract that establishes the relationship between an insured (the purchaser), the agent intermediary) and the insurance company (insurer). It pledges the unearned portion of the insurance policy to secure the money advanced by the premium finance company on behalf of the purchaser, and grants a limited power of attorney to the premium finance company to cancel the policy in the event of non-payment of premium.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		
																		<section id="t_and_d_regulation_z">
																			<h4 class="mt-5 mb-2">Regulation Z</h4>
																			<p>Published by the Board of Governors of the Federal Reserve System, this publication consists of Annual Percentage Rate Tables. Any finance charge can be converted to an add-on rate by dividing the finance charge by the amount financed. The add-on rate can then be converted to an APR by simply finding the number of installments on the left and reading across until the add-on rate is found. (Add-on rates that fall between published rates are easily interpolated.) The APR is then read at the top of the column.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_rule_of_78">
																			<h4 class="mt-5 mb-2">Rule of 78</h4>
																			<p>The "Rule of 78", also known as the "Sum of the Digits" method of earning interest and apportioning it according to how much of the balance due remains unpaid. 78 is the sum of the digits 1 through 12. As an example, interest on a 12-month loan would be apportioned as follows: in Month One, 12/78 or .1538 of the finance charge becomes earned interest and is taken into income. In Month Two, 11/78 or .1410 of the finance charge becomes earned interest and is taken into income. In Month Three, 10/78 or .1282, and so forth. In the premium finance context, most contracts are written on a 9-month basis, so this becomes the "Rule of 45" if you will.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
																		<section id="t_and_d_unearned_premium">
																			<h4 class="mt-5 mb-2">Unearned Premium</h4>
																			<p>For an individual policy, that portion of the premium not yet earned by the insurance company. If cancelled, that part of the premium that would be returned to the insured. The unearned portion can be computed on a pro-rata or short-rate basis. See Pro-Rata and Short-Rate.</p>
																			<p><a class="top-link hide" href="#top"><i class="fa-sharp fa-solid fa-chevron-up color-3"></i></a></p>
																		</section>
																		
			                          					                          					                          																			
																			</ul>
				                            </div>
				                        </div>
				                    </div>
					                  
					                    <!-- /.col-*-->
					              </div>
					                <!--/.row-->
					            </div>
					            <!--/.container-->
					        </section>
</x-app-layout>


