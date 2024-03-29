<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SAB PVT LTB</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="overflow-x-hidden" onload="ready()">
    <!-- loading section -->
    <x-loading></x-loading>
    <!-- end loading section -->
    <!-- navbar -->
    <x-top-bar></x-top-bar>
    <!-- end navbar -->
    <div id="section-container" class="absolute inset-0 overflow-hidden">
        <!-- hero section -->
        <x-hero-section id="hero" class="section"></x-hero-section>
        <div class="container mx-auto">
            <!-- end hero section -->
            <!-- service section -->
            <x-service-section id="service" class="section"></x-service-section>
            <!-- end service section -->
            <!-- counter up section -->
            <x-count-section :other="$other" id="counter-up" class="section"></x-count-section>
            <!-- end counter up section -->
            <!-- what we do section -->
            <x-what-we-do-section :other="$other" id="what-we-do" class="section"></x-what-we-do-section>
            <!-- end what we do section -->
            <!-- latest work section -->
            <x-latest-work-section id="latest-work" class="section"></x-latest-work-section>
            <!-- end latest work section -->
            <!-- about section -->
            <x-about-section :other="$other" id="about" class="section"></x-about-section>
            <!-- end abount section -->
        </div>
        <!-- contact section -->
        <x-contact-section id="contact" class="section"></x-contact-section>
        <!-- end contact section -->
        <!-- footer section -->
        <x-footer-section id="footer" class="section"></x-footer-section>
        <!-- end section -->
    </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer="false"></script>
    <script src="{{mix('js/counter.js')}}"></script>
    <script src="{{asset('storage/qrcode.min.js')}}"></script>
    <script>
        let heroInterval = '';
        function ready (){
            // navbar toggle function
            $('#menu-toggle').on('click',function(){
                $('#collaps-menu').toggleClass(['hidden','active']);
            });
            // latest work slide
            if($('.slider-item').length > 3){
                $('#myRange').removeClass('lg:hidden');
            }
            $('#myRange').attr('max',$('.slider-item').length);
            $('#myRange').on('input change', function(){
                // console.log($(this).val());
                let left = 0;
                if($(this).val() != 1){
                    left = -($(this).val() * 200);
                }else{
                    left = 0;
                }
                $('.scroll-content').css('margin-left', left)
            });

            // qr code
            const qrcodeData = `
            {{route('home')}},
            contact number: +880 1700-00000,
            mail: {{env('MAIL_FROM_ADDRESS')}}
            `;
            let qrcode = new QRCode(document.getElementById("qrcode"));
            qrcode.makeCode(qrcodeData);
            // loading screen
            const certerBar = $('#center-progress-bar > .bar')[0];
            let timeout = setInterval(() => {
                const computedStyle = getComputedStyle(certerBar);
                const width = parseInt(computedStyle.getPropertyValue('--width')) || 0;
                certerBar.style.setProperty('--width',width + 1);
                if(width <= 100){ $('#percentage').text(width +' %') } if(width> 100){
                    // console.log(width);
                    $('.center-progress-container').addClass('hidden');
                    $('#top-progress-bar').addClass('active');
                    $('#top-door').addClass('active');
                    $('#bottom-door').addClass('active');
                    clearInterval(timeout);
                    document.getElementById('top-progress-bar').addEventListener("transitionend", function(){
                    // $('#main-container').removeClass('hidden');
                    $('#sb-loading-container').addClass('hidden');
                    $('#section-container').removeClass(['absolute' ,'inset-0','overflow-hidden']);
                        $('#section-container').addClass(['w-full' ,'h-screen']);
                        let count = 0;
                        heroInterval = setInterval(() => {
                            if(count >= ($('.hero-image').attr('data-img').split(',').length - 1)){
                                count = 0;
                            }else{
                                count++;
                            }
                            heroSlide(count)
                        }, (1000 * 5));
                    });
                }
            }, 5);

            // scroll 
            var hashTagActive = "";
            $(".section-ancor .nav-link").on("click touchstart" , function (event) {
                if(hashTagActive != this.hash) { //this will prevent if the user click several times the same link to freeze the scroll.
                    event.preventDefault();
                    //calculate destination place
                    var dest = 0;
                    if ($(this.hash).offset().top > $(document).height() - $(window).height()) {
                        dest = $(document).height() - ($(window).height());
                    // console.log($(this.hash).offset().top);
                    } else {
                        dest = $(this.hash).offset().top;
                    }
                    // console.log($(this.hash).offset().top);
                    //go to destination
                    $('html,body').animate({
                        scrollTop: dest
                    }, 2000, 'swing');
                    hashTagActive = this.hash;
                    $('.section-ancor .nav-link').removeClass('active');
                    $(this).addClass('active');
                }
            });

            $('.feature-item .feature-item-title').on('click',function(e){
                e.preventDefault();
                $(this).parent().next().addClass('active');
            });
        }
        // hero slide
        function heroSlide(count){
            // console.log(count);
            let imgset = JSON.parse($('.hero-image').attr('data-img'))[count];
            if(imgset == undefined){
                clearInterval(heroInterval);
            }
            else{
                $('.hero-image').css('background-image','url('+imgset+')');
            }
        }

        function closeModal(){
            $('.modal').removeClass('active');
        }
    </script>
</body>

</html>