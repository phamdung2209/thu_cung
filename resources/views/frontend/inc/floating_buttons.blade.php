<div class="floating-buttons-section">
    <a class="floating-buttons-section-control d-lg-none" onclick="showFloatingButtons()">
        <i class="las la-2x la-angle-double-right"></i>
    </a>
    <!-- All Categories -->
    <div class="aiz-floating-button">
        <a href="{{ route('categories.all') }}">
            <span class="circle">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14">
                        <g id="Group_29240" data-name="Group 29240" transform="translate(-18 -18)">
                          <rect id="Rectangle_21398" data-name="Rectangle 21398" width="15" height="2" transform="translate(18 24)" fill="#fff"/>
                          <rect id="Rectangle_21399" data-name="Rectangle 21399" width="15" height="2" transform="translate(18 18)" fill="#fff"/>
                          <rect id="Rectangle_21400" data-name="Rectangle 21400" width="15" height="2" transform="translate(18 30)" fill="#fff"/>
                        </g>
                    </svg>
                </span>
            </span>
            <span class="text">
                <span class="w-120px mr-3">{{ translate('All Categories') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="7.073" height="12" viewBox="0 0 7.073 12">
                    <path id="Path_41557" data-name="Path 41557" d="M12.913,3.173,11.834,2.1,5.84,8.1l6,6,1.073-1.073L7.985,8.1Z" transform="translate(12.913 14.1) rotate(180)" fill="#fff"/>
                </svg>
            </span>
        </a>
    </div>
    <!-- Flash Sale -->
    <div class="aiz-floating-button">
        <a href="{{ route('flash-deals') }}">
            <span class="circle">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13.333" height="20" viewBox="0 0 13.333 20">
                        <path id="Path_41551" data-name="Path 41551" d="M28.294,12.246a.4.4,0,0,0-.353-.209H23.855l3.264-6.508a.352.352,0,0,0-.023-.357A.4.4,0,0,0,26.765,5H20.49a.394.394,0,0,0-.358.219l-5.1,10.741a.353.353,0,0,0,.029.353.4.4,0,0,0,.329.169h3.827l-1.857,8.069a.365.365,0,0,0,.216.414.407.407,0,0,0,.476-.106l10.2-12.222a.354.354,0,0,0,.045-.391Z" transform="translate(-15 -5)" fill="#fff"/>
                      </svg>
                </span>
            </span>
            <span class="text">
                <span class="w-120px mr-3">{{ translate('Flash Sale') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="7.073" height="12" viewBox="0 0 7.073 12">
                    <path id="Path_41557" data-name="Path 41557" d="M12.913,3.173,11.834,2.1,5.84,8.1l6,6,1.073-1.073L7.985,8.1Z" transform="translate(12.913 14.1) rotate(180)" fill="#fff"/>
                </svg>
            </span>
        </a>
    </div>
    <!-- Today's Deal -->
    <div class="aiz-floating-button">
        <a href="{{ route('todays-deal') }}">
            <span class="circle">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <g id="a47ac3ccd1557f7fbdb769f1c535b2b9" transform="translate(0 0)">
                          <path id="Path_41552" data-name="Path 41552" d="M10,0A10,10,0,1,0,20,10,10,10,0,0,0,10,0Zm0,18.333A8.333,8.333,0,1,1,18.333,10,8.333,8.333,0,0,1,10,18.333Z" fill="#fff"/>
                          <path id="Path_41553" data-name="Path 41553" d="M17.515,14.143,13,11.434V6a1,1,0,0,0-2,0v6a1.075,1.075,0,0,0,.485.857l5,3a1,1,0,1,0,1.03-1.714Z" transform="translate(-2.588 -1.538)" fill="#fff"/>
                        </g>
                    </svg>
                </span>
            </span>
            <span class="text">
                <span class="w-120px mr-3">{{ translate("Today's Deal") }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="7.073" height="12" viewBox="0 0 7.073 12">
                    <path id="Path_41557" data-name="Path 41557" d="M12.913,3.173,11.834,2.1,5.84,8.1l6,6,1.073-1.073L7.985,8.1Z" transform="translate(12.913 14.1) rotate(180)" fill="#fff"/>
                </svg>
            </span>
        </a>
    </div>
    @if(addon_is_activated('auction'))
    <!-- Auction -->
    <div class="aiz-floating-button">
        <a href="{{ route('auction_products.all') }}">
            <span class="circle">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19.627" height="20" viewBox="0 0 19.627 20">
                        <g id="cb3bc0b728579e634f654dfaf5995832" transform="translate(-8 -7.122)">
                          <rect id="Rectangle_21402" data-name="Rectangle 21402" width="2.455" height="5.729" rx="1.228" transform="translate(10.102 16.386) rotate(-45)" fill="#fff"/>
                          <rect id="Rectangle_21403" data-name="Rectangle 21403" width="2.455" height="5.729" rx="1.228" transform="translate(17.623 8.858) rotate(-45)" fill="#fff"/>
                          <rect id="Rectangle_21404" data-name="Rectangle 21404" width="4.91" height="6.547" rx="2" transform="translate(12.702 13.203) rotate(-45)" fill="#fff"/>
                          <rect id="Rectangle_21405" data-name="Rectangle 21405" width="1.637" height="4.092" transform="translate(12.414 15.225) rotate(-45)" fill="#fff"/>
                          <rect id="Rectangle_21406" data-name="Rectangle 21406" width="1.637" height="4.092" transform="translate(17.043 10.599) rotate(-45)" fill="#fff"/>
                          <path id="Path_41554" data-name="Path 41554" d="M21.721,14.563l.577.577L21.14,16.3l-.577-.577a.819.819,0,1,1,1.158-1.158Z" transform="translate(-7.281 -4.255)" fill="#fff"/>
                          <rect id="Rectangle_21407" data-name="Rectangle 21407" width="1.637" height="4.501" transform="translate(18.489 16.673) rotate(-45)" fill="#fff"/>
                          <path id="Path_41555" data-name="Path 41555" d="M41.235,36.393l1.158-1.158a.409.409,0,0,1,.581,0L46.833,39.1a1.228,1.228,0,0,1,0,1.735h0a1.228,1.228,0,0,1-1.735,0l-3.863-3.859a.409.409,0,0,1,0-.581Z" transform="translate(-19.564 -16.538)" fill="#fff"/>
                          <rect id="Rectangle_21408" data-name="Rectangle 21408" width="12.276" height="1.637" transform="translate(8 25.485)" fill="#fff"/>
                          <path id="Path_41556" data-name="Path 41556" d="M11.637,48H19a1.637,1.637,0,0,1,1.637,1.637H10A1.637,1.637,0,0,1,11.637,48Z" transform="translate(-1.182 -24.151)" fill="#fff"/>
                        </g>
                    </svg>
                </span>
            </span>
            <span class="text">
                <span class="w-120px mr-3">{{ translate('Auction') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="7.073" height="12" viewBox="0 0 7.073 12">
                    <path id="Path_41557" data-name="Path 41557" d="M12.913,3.173,11.834,2.1,5.84,8.1l6,6,1.073-1.073L7.985,8.1Z" transform="translate(12.913 14.1) rotate(180)" fill="#fff"/>
                </svg>
            </span>
        </a>
    </div>
    @endif
</div>

