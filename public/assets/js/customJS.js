$(document).ready(function () {
    $('.banner-main-slider').slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      fade: false,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 3000,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>',
    });
  });
  
       
  $(document).ready(function () {
    $('.slideCategory').slick({
      dots: false,
      infinite: true,
      speed: 500,
      slidesToShow: 8,
      fade: false,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 3000,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>',
    });
  });
  
  





$(document).ready(function () {
    $(".category-section").slick({
        // dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 8,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
    });
});

$(document).ready(function () {
    // Target the span with class 'product-item'
    $(".new-price").each(function () {
        const spanText = $(this).text();

        // Replace '.00' with an empty string
        const newText = spanText.replace(".00", "");

        // Set the new text back to the span
        $(this).text(newText);
    });
});
  


$(document).ready(function () {
  // Target the span with class 'product-item'
  $(".rating-count").each(function () {
      const NumberRating = $(this).text();

      // Replace '.00' with an empty string
      const Rating = NumberRating.replace(".0000", ".0");

      // Set the new text back to the span
      $(this).text(Rating);
  });
});