/* =============================================
   SHREE KALIKA ENTERPRISES — ske.js
   ============================================= */

$(function () {

    /* ── Navbar scroll ───────────────────────── */
    $(window).on('scroll.navbar', function () {
        $('.navbar').toggleClass('scrolled', $(this).scrollTop() > 60);
    });

    /* ── Mobile nav ──────────────────────────── */
    $('.hamburger').on('click', function () {
        $(this).toggleClass('active');
        $('.mobile-nav').toggleClass('open');
        $('body').toggleClass('no-scroll');
    });
    $('.mobile-close').on('click', closeMobileNav);
    $(document).on('click', function (e) {
        if ($('.mobile-nav').hasClass('open') && !$(e.target).closest('.mobile-nav,.hamburger').length) {
            closeMobileNav();
        }
    });
    function closeMobileNav() {
        $('.hamburger').removeClass('active');
        $('.mobile-nav').removeClass('open');
        $('body').removeClass('no-scroll');
    }

    /* ── Mobile accordion ────────────────────── */
    $('.mobile-nav-item > a').on('click', function (e) {
        var $item = $(this).parent();
        if ($item.find('.mobile-cat').length) {
            e.preventDefault();
            $item.toggleClass('open').siblings().removeClass('open');
        }
    });
    $('.mobile-cat-item > a').on('click', function (e) {
        var $item = $(this).parent();
        if ($item.find('.mobile-sub').length) {
            e.preventDefault();
            $item.toggleClass('open');
        }
    });

    /* ── Scroll reveal ───────────────────────── */
    function checkAnimations() {
        var bottom = $(window).scrollTop() + $(window).height();
        $('[data-animate]:not(.in-view)').each(function () {
            if ($(this).offset().top < bottom - 50) $(this).addClass('in-view');
        });
    }
    $(window).on('scroll.anim', checkAnimations);
    checkAnimations();

    /* ── Counter animation ───────────────────── */
    function animateCounter($el) {
        var target  = parseInt($el.data('target')) || 0;
        var suffix  = $el.data('suffix') || '';
        var start   = 0;
        var step    = Math.ceil(target / 80);
        var timer   = setInterval(function () {
            start += step;
            if (start >= target) { clearInterval(timer); $el.text(target + suffix); }
            else { $el.text(start + suffix); }
        }, 20);
    }
    $('[data-counter]').each(function () { animateCounter($(this)); });

    /* ── Testimonials slider ─────────────────── */
    var $track = $('#testiTrack');
    if ($track.length) {
        var $cards    = $track.find('.testimonial-card');
        var total     = $cards.length;
        var current   = 0;
        var autoTimer = null;

        function pv() {
            var w = $(window).width();
            return w <= 600 ? 1 : w <= 900 ? 2 : 3;
        }
        function cardW() {
            var p   = pv();
            var gap = (p - 1) * 24;
            return ($track.parent().width() - gap) / p;
        }
        function setSizes() {
            var cw = cardW();
            $cards.css({ flex: '0 0 ' + cw + 'px', 'min-width': cw + 'px' });
        }
        function buildDots() {
            var $d = $('#testiDots').empty();
            var pages = Math.ceil(total / pv());
            for (var i = 0; i < pages; i++) {
                $('<button class="testi-dot" data-idx="' + i + '"></button>').appendTo($d);
            }
            updateDots();
        }
        function updateDots() {
            var page = Math.floor(current / pv());
            $('#testiDots .testi-dot').removeClass('active').eq(page).addClass('active');
        }
        function goTo(idx) {
            var p   = pv();
            var max = Math.max(0, total - p);
            current = Math.max(0, Math.min(idx, max));
            var offset = current * (cardW() + 24);
            $track.css('transform', 'translateX(-' + offset + 'px)');
            $cards.removeClass('active-slide').slice(current, current + p).addClass('active-slide');
            updateDots();
        }
        function startAuto() {
            clearInterval(autoTimer);
            autoTimer = setInterval(function () {
                var next = current + pv();
                goTo(next >= total ? 0 : next);
            }, 4500);
        }

        $('#testiBtnNext').on('click', function () { var n = current + pv(); goTo(n >= total ? 0 : n); startAuto(); });
        $('#testiBtnPrev').on('click', function () { var n = current - pv(); goTo(n < 0 ? Math.max(0, total - pv()) : n); startAuto(); });
        $('#testiDots').on('click', '.testi-dot', function () { goTo($(this).data('idx') * pv()); startAuto(); });

        /* Touch swipe */
        var tx = 0;
        $track[0].addEventListener('touchstart', function (e) { tx = e.changedTouches[0].screenX; }, { passive: true });
        $track[0].addEventListener('touchend', function (e) {
            var diff = tx - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) {
                var p = pv();
                if (diff > 0) { var n = current + p; goTo(n >= total ? 0 : n); }
                else          { var n = current - p; goTo(n < 0 ? Math.max(0, total - p) : n); }
                startAuto();
            }
        }, { passive: true });

        $(window).on('resize.testi', function () {
            clearTimeout(window._tr);
            window._tr = setTimeout(function () { setSizes(); buildDots(); goTo(0); }, 200);
        });

        setSizes(); buildDots(); goTo(0); startAuto();
    }

    /* ── Product image gallery ───────────────── */
    $(document).on('click', '.product-thumb-item', function () {
        var src = $(this).data('src');
        var alt = $(this).data('alt') || '';
        $('.product-thumb-item').removeClass('active');
        $(this).addClass('active');
        $('#mainProductImg').attr('src', src).attr('alt', alt);
    });

    /* ── Gallery Lightbox ────────────────────── */
    var lightboxImages = [];
    var lightboxIndex  = 0;

    $(document).on('click', '.gallery-item', function () {
        lightboxImages = [];
        $('.gallery-item').each(function () {
            lightboxImages.push({ src: $(this).data('full'), caption: $(this).data('caption') || '' });
        });
        lightboxIndex = $('.gallery-item').index(this);
        openLightbox(lightboxIndex);
    });

    function openLightbox(idx) {
        if (!lightboxImages[idx]) return;
        lightboxIndex = idx;
        var img = lightboxImages[idx];
        $('#lightboxImg').attr('src', img.src).attr('alt', img.caption);
        $('#lightboxCaption').text(img.caption);
        $('#skeLightbox').addClass('open');
        $('body').addClass('no-scroll');
    }

    $(document).on('click', '#lightboxClose, #skeLightbox', function (e) {
        if ($(e.target).is('#skeLightbox') || $(e.target).is('#lightboxClose') || $(e.target).closest('#lightboxClose').length) {
            $('#skeLightbox').removeClass('open');
            $('body').removeClass('no-scroll');
        }
    });
    $(document).on('click', '#lightboxPrev', function (e) {
        e.stopPropagation();
        var prev = lightboxIndex - 1;
        openLightbox(prev < 0 ? lightboxImages.length - 1 : prev);
    });
    $(document).on('click', '#lightboxNext', function (e) {
        e.stopPropagation();
        var next = lightboxIndex + 1;
        openLightbox(next >= lightboxImages.length ? 0 : next);
    });
    $(document).on('keydown', function (e) {
        if (!$('#skeLightbox').hasClass('open')) return;
        if (e.key === 'ArrowLeft')  $('#lightboxPrev').trigger('click');
        if (e.key === 'ArrowRight') $('#lightboxNext').trigger('click');
        if (e.key === 'Escape')     $('#lightboxClose').trigger('click');
    });

    /* ── AJAX Inquiry form ───────────────────── */
    $(document).on('submit', '#inquiryForm', function (e) {
        e.preventDefault();
        var $btn  = $(this).find('[type=submit]');
        var $msg  = $('#inquiryMsg');
        $btn.prop('disabled', true).text('Sending…');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    $msg.html('<div class="alert-success-ske"><i class="fa-solid fa-circle-check"></i> ' + res.message + '</div>');
                    $('#inquiryForm')[0].reset();
                    setTimeout(function () { $('#inquiryModal').modal && $('#inquiryModal').modal('hide'); }, 2000);
                }
            },
            error: function () {
                $msg.html('<div class="alert-error-ske">Something went wrong. Please try again.</div>');
            },
            complete: function () {
                $btn.prop('disabled', false).text('Send Enquiry');
            }
        });
    });

    /* ── Smooth scroll ───────────────────────── */
    $('a[href^="#"]:not([href="#"])').on('click', function (e) {
        var $t = $(this.hash);
        if ($t.length) { e.preventDefault(); $('html,body').animate({ scrollTop: $t.offset().top - 80 }, 600); }
    });

});

/* no-scroll utility */
(function () {
    var s = document.createElement('style');
    s.textContent = '.no-scroll{overflow:hidden;}';
    document.head.appendChild(s);
}());
