<?php

$footer = '</div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#updwn").click(function () {
                        $(".menu").slideToggle(300);
                        $("#updwn").toggleClass("up");
                    });
                });

                window.addEventListener("orientationchange", hideAddressBar);
                window.addEventListener("load", hideAddressBar);

                function hideAddressBar() {
                    setTimeout(function () {
                        window.scrollTo(0, 1);
                    }, 0);
                }
            </script>
        </body>
    </html>';