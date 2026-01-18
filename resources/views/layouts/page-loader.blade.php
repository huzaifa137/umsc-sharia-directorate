        <div id="pageLoader" class="page-loader d-none">
            <div class="loader-content">
                <i class="bx bx-loader bx-spin fs-1 text-success"></i>
                <p class="mt-3">Processing, please wait...</p>
            </div>
        </div>

        <style>
            .page-loader {
                position: fixed;
                inset: 0;
                background: rgba(255, 255, 255, 0.85);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .d-none {
                display: none !important;
            }
        </style>
