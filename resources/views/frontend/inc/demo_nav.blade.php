<!-- Demo nav -->
<div class="aiz-demo-nav">
    <!-- Mobile bottom nav toggler-->
    <div class="bg-white position-relative">
        <a href="javascript:void(0);" class="position-relative aiz-demo-nav-item aiz-demo-nav-toggler">
            <div class="aiz-demo-nav-btn">
                <div class="line line--1"></div>
                <div class="line line--2"></div>
                <div class="line line--3"></div>
            </div>
            <span>{{ translate('Demos') }}</span>
        </a>
    </div>
    <!-- Mobile bottom nav toggler-->
    <div class="aiz-demo-nav-links">
        <a href="https://activeitzone.com/docs/active-ecommerce-cms/" class="aiz-demo-nav-item" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24">
                <path id="Google_Docs" data-name="Google Docs" d="M20.85,5.15l-5-5A.5.5,0,0,0,15.5,0H5A2,2,0,0,0,3,2V22a2,2,0,0,0,2,2H19a2,2,0,0,0,2-2V5.5a.5.5,0,0,0-.15-.35ZM12.5,18h-5a.5.5,0,0,1,0-1h5a.5.5,0,0,1,0,1Zm4-2h-9a.5.5,0,0,1,0-1h9a.5.5,0,0,1,0,1Zm0-2h-9a.5.5,0,0,1,0-1h9a.5.5,0,0,1,0,1Zm0-2h-9a.5.5,0,0,1,0-1h9a.5.5,0,0,1,0,1ZM17,5a1,1,0,0,1-1-1V1.71L19.29,5Z" transform="translate(-3)" fill="gray"/>
            </svg>
            <span class="mt-1">{{ translate('Docs') }}</span>
        </a>
        <a href="https://www.youtube.com/watch?v=FFjausSYe3M" class="aiz-demo-nav-item" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="24" viewBox="0 0 23.999 24">
                <g id="Group_28098" data-name="Group 28098" transform="translate(4436.999 -9778.001)">
                  <path id="Subtraction_193" data-name="Subtraction 193" d="M23,24H1a1,1,0,0,1,0-2H23a1,1,0,1,1,0,2Zm-3-4H4a4,4,0,0,1-4-4V4A4.005,4.005,0,0,1,4,0H20a4,4,0,0,1,4,4V16A4,4,0,0,1,20,20ZM4,2A2,2,0,0,0,2,4V16a2,2,0,0,0,2,2H20a2,2,0,0,0,2-2V4a2,2,0,0,0-2-2Z" transform="translate(-4437 9778)" fill="gray"/>
                  <path id="Polygon_6" data-name="Polygon 6" d="M5,0l5,8H0Z" transform="translate(-4420 9783) rotate(90)" fill="gray"/>
                </g>
            </svg>
            <span class="mt-1">{{ translate('Tutorial') }}</span>
        </a>
        <a href="https://www.youtube.com/watch?v=zW6FwRsaxDk" class="aiz-demo-nav-item" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18">
                <path id="_17d8c74bcbdc9c556fab58cca92da0f6" data-name="17d8c74bcbdc9c556fab58cca92da0f6" d="M23.76,7.881a5.768,5.768,0,0,0-.953-2.542,3.312,3.312,0,0,0-2.4-1.082C17.044,4,12.005,4,12.005,4h-.011s-5.038,0-8.4.26a3.306,3.306,0,0,0-2.4,1.082A5.773,5.773,0,0,0,.24,7.881,41.231,41.231,0,0,0,0,12.023v1.941a41.217,41.217,0,0,0,.24,4.143,5.756,5.756,0,0,0,.953,2.54A3.926,3.926,0,0,0,3.839,21.74C5.759,21.936,12,22,12,22s5.043-.009,8.4-.266a3.324,3.324,0,0,0,2.4-1.085,5.766,5.766,0,0,0,.953-2.54A41.236,41.236,0,0,0,24,13.964V12.023a41.231,41.231,0,0,0-.24-4.142ZM9,17.5v-9l7.5,4.5Z" transform="translate(0 -3.997)" fill="gray"/>
            </svg>
            <span class="mt-1">{{ translate('Promo') }}</span>
        </a>
    </div>
</div>

<!-- Demo content -->
<div class="aiz-demos">
    <div class="aiz-demo-content">
        <div class="px-2rem">
            <div class="row gutters-16">
                <!-- Main Demo -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_main.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Active eCommerce Main Demo') }}</p>
                </div>
                <!-- Grocery Store -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-grocery/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_grocery.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Grocery Store') }}</p>
                </div>
                <!-- Electronics Shop -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-electronics/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_technology.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Electronics Shop') }}</p>
                </div>
                <!-- Fashion Store -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-fashion/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_fashion.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Fashion Store') }}</p>
                </div>
                <!-- Automobile Store -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-automobile/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_automobile.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Automobile Store') }}</p>
                </div>
                <!-- Furniture Store -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-furniture/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_furniture.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Furniture Store') }}</p>
                </div>
                <!-- Medical Store -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <a href="https://demo.activeitzone.com/ecommerce-medical/" target="_blank" class="h-100 w-100">
                            <img src="{{ static_asset('assets/img/demo/demo_thumb_medical.png') }}">
                        </a>
                    </div>
                    <p class="demo-title">{{ translate('Medical Store') }}</p>
                </div>
                <!-- Demo content -->
                <div class="col-md-6 my-3">
                    <div class="demo-img-content">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="lds-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <p class="demo-title">{{ translate('Coming Soon') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>