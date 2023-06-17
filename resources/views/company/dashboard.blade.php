<x-app-layout>


    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <!--i class="fa-light fa-wave-pulse mb-4"><span class="font-1 fw-600 fs-2 color-2"> Dashboard</span></span-->
                    <div class="my-4"></div>
                    <div class="row">
                    <h2>Welcome Back!</h2>
                    </div>
                    <div class="row my-1">
                    	<p> <?php echo "It's " . date("l F jS Y g:i A");?></p>
                        <!-- span style="style="font-family: 'Poppins', sans-serif;" class="mt-3 fs-1 color-black">Dashboard</span -->
                    </div>
                </div><!-- /.col-*-->
            </div>
            <!--/.row-->
            <div class="row">
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-6">50</span>
                        <p class="fw-400">Open Quotes</p>
                    </div>
                    <!-- p class="color-5 mb-0 fs--1">Optimized for every screen size down to a single pixel.</p -->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-6">100</span>
                        <p class="fw-400">Active Accounts</p>
                    </div>
                    <!--p class="color-5 mb-0 fs--1">Finally, you can now create multiverse websites effortlessly.</p -->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-6">$10,000</span>
                        <p class="fw-400">MTD Financed Amount</p>
                    </div>
                    <!-- p class="color-5 mb-0 fs--1">If you are not satisfied, just let us know. We will refund you right away.</p -->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-6">$100,000</span>
                        <p class="fw-400">YTD Financed Amount</p>
                    </div>
                    <!--p class="color-5 mb-0 fs--1">A dedicated support team to handle any of your issues.</p -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-2">2</span>
                        <p class="fw-400">Draft Quotes</p>
                    </div>
                    <!--p class="color-5 mb-0 fs--1">Quotes that you have started and have not completed.</p-->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-warning">2</span>
                        <p class="fw-400">Intent to Cancel Accounts</p>
                    </div>
                    <!-- p class="color-5 mb-0 fs--1">Accounts that are in Intent to Cancel Status</p -->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-danger">1</span>
                        <p class="fw-400">Cancel Accounts</p>
                    </div>
                    <!-- p class="color-5 mb-0 fs--1">Accounts that are in Cancel Status.</p -->
                </div>
                <div class="col-lg-3 col-md-6 py-5 px-xl-4 px-2">
                    <div class="dashboard-box">
                        <span class="d-block mb-3 fs-4 color-primary">70</span>
                        <p class="fw-400">Insureds</p>
                    </div>
                    <!-- p class="color-5 mb-0 fs--1">Finally, you can now create multiverse websites effortlessly.</p -->
                </div>
                <!-- div class="col-12">
						<hr class="color-9">
					</div -->
            </div>
        </div>
        <!--/.container-->
    </section>
    <!--/.section-->
</x-app-layout>
