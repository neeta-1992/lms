<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
					<div class="row mt-5">
						<h2><i class="fa-light fa-wave-pulse mb-4"></i> Welcome Back!</h2>
					</div>
                    <div class="row my-1">
						<?php echo "It's " . date("l F jS Y g:i A");?>
                    </div>
                </div><!-- /.col-*-->
            </div>
            <!--/.row-->
         </div>
        <!--/.container-->
    </section>
    <!--/.section-->
    @push('page_script_code')
        <script>
            setCookie("loginPrefix", 'enetworks', {
                expires: 10
            });
        </script>
    @endpush
</x-app-layout>