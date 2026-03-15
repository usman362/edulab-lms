<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one
        pageTitle="Contact" 
        pageRoute="{{ route('contact.page') }}" 
        pageName="Contact" 
    />
    <!-- START CONTACT OVERVIEW -->
    <div class="container">
        <div class="grid grid-cols-12 gap-4 xl:gap-7">
            <x-theme::contact-form.contact-information />
        </div>
    </div>
    <!-- END CONTACT OVERVIEW -->
    <!-- START CONTACT FORM -->
    <div class="bg-primary-50 mt-16 sm:mt-24 lg:mt-[120px] -mb-16 sm:-mb-24 lg:-mb-[120px] relative overflow-hidden">
        <div class="container">
            <div class="grid grid-cols-2">
                <div class="col-span-full lg:col-auto bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
                    <h5 class="area-title">{{ translate('Free Consultation') }}</h5>
                    <x-theme::contact-form.form class="mt-10 lg:max-w-screen-sm lg:pr-[10%] rtl:lg:pr-0 rtl:lg:pl-[10%]" formType="support" />
                </div>
                <div class="col-span-full lg:col-auto bg-primary-50 lg:absolute lg:w-1/2 lg:h-full lg:top-0 lg:bottom-0 lg:!right-0 rtl:lg:!right-auto rtl:lg:!left-0 hidden lg:block">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d226297.4644709468!2d152.86719!3d-27.46794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b91579aac93d233%3A0x402a35af3deaf40!2sBrisbane%20QLD%2C%20Australia!5e0!3m2!1sen!2sau!4v1700000000000!5m2!1sen!2sau"
                        width="100%" height="100%" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTACT FORM -->
</x-frontend-layout>
