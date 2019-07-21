
// console.log('test');

$(document).ready(function(){
   
    function numberFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    
    function calculateDiscount($price, $discount){
        return result = $price - ($price * $discount / 100);
    }
    var myObject = {key: "AIzaSyDDmI1OLJfpzhprJACpBpXbkVg1oGoHlKc"};
    var getProductAPI = 'http://localhost:8088/dwsmarketplace/rest/api.php/product';
    
    $.getJSON( getProductAPI, {
        auth: "AIzaSyDDmI1OLJfpzhprJACpBpXbkVg1oGoHlKc",
    }).done(function( result ) {
        console.log(result);
        $.each( result.data, function( i, item ) {
        $(
        '<div class="col-5">'+
            '<div class="ProductItem">'+
                "<img class='ProductImage' src='assets/images/product/small_"+item.product_image+"' />"+
                "<div class='ProductName'>"+((item.product_name).length > 50 ? (item.product_name).substring(0, 50) + ' ...':item.product_name)+"</div>"+
                
                (item.discount > 0 ? '<span class="DiscountLabel">-'+item.discount+'%</span>'+ '<div class="DiscountPrice">'+numberFormat(item.product_price)+' IDR</div>' : '<div class="DiscountPrice"></div>') +
                
                '<div class="ProductPrice">'+numberFormat(calculateDiscount(item.product_price, item.discount))+' IDR</div>'+
                '<a class="btnBuy" href="'+item.clean_url+'"><i class="glyphicon glyphicon-search"></i> VIEW PRODUCT</a>'+
            "</div>"+
        "</div>" 
        ).appendTo( "#listProduct" );
        });
    });

    $("#search").keyup(function() {
        var str = $("#search").val();
        if (str == "") {
            $("#list_search").html("");
            $('#list_search').hide();
        } else {
            $.get("{{ url('demos/livesearch?id=') }}" + str, function(data) {
                $('#list_search').show();
                $('#list_search').html('');
                $('#list_search').append("<div id='helper-text-search-box-hotel'>Type more to get more relevant results</div>");

                if (data.count != 0) {

                    for (var i = 0; i < data.count; i++) {
                        $('#list_search').append("<div class='list-hotel' data-value='" + JSON.parse(JSON.stringify(data.hotels[i].name)) + "'><div class='hotel_name'>" + JSON.parse(JSON.stringify(data.hotels[i].name)) + "</div><div class='hotel_location'>" + JSON.parse(JSON.stringify(data.hotels[i].city_name)) + ", " + JSON.parse(JSON.stringify(data.hotels[i].country)) + "</div></div>");
                        //console.log(data.count);
                    }

                } else {
                    $('#list_search').append("<div class='resultNotFound'><h4>There are no results for '<strong>" + str + "</strong>'</h4><small>Try other keywords and check your connection</small></div>");
                }

            });
        }
    });

    $(".account ul li").hover(function(){
        $(".account > a").addClass("isHover");
    },function(){
        $(".account > a").removeClass('isHover');
    });
    $(".txtSearch").focus(function(){
        $(".search_icon").css({'opacity':'0.8', 'transition':'all 0.3s ease-out'});
    });

    $(".txtSearch").focusout(function(){
        $(".search_icon").css({'opacity':'0.4'});
        
    });
    $(".searchBox").hover(function(){
        $(".searchBox").css({'background-color':'#e9e9e9', 'transition':'all 0.3s ease-out'});
    }, function(){
        $(".searchBox").css({'background-color':'#f1f1f1'});
    });

    // Slider

//   $('#checkbox').change(function(){

    setInterval(function () {
        moveRight();
    }, 10000);

//   });
  
	var slideCount     = $('#slider ul li').length;
	var slideWidth     = $('#slider ul li').width();
	var slideHeight    = $('#slider ul li').height();
	var sliderUlWidth  = slideCount * slideWidth;
	
	$('#slider').css({ width: slideWidth, height: slideHeight });
	
	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('div.control_prev').click(function () {
        moveLeft();
    });

    $('div.control_next').click(function () {
        moveRight();
    });
    
});

// Scroll Effect
$(window).scroll(function() {
	if($('html,body').width() > 1000){
        
		if ($(this).scrollTop() > 150) {	
            $("header").css({
                "transition":"all 0.7s ease-out",
                "position":"fixed",
            });
            $("header").slideDown();
            $(".menu").slideUp();
            $("nav").slideUp();
		}
		else{
            $("nav").fadeIn();
            $(".menu").slideDown();
            $("header").css(
            {
                "position":"fixed",
                "transition":"all 0.7s ease-out"
            });	
		};
	};
});

$(document).on("click", '.toggle', function(e) {
    // $('.toggle').click(function(e) {
    e.preventDefault();

    var $this = $(this);
    console.log($this);
    
    if ($this.parent().parent().next().hasClass('show')) {
        $this.html('View Details <i class="glyphicon glyphicon-chevron-down"></i>');
        $this.parent().parent().next().removeClass('show');
        $this.parent().parent().next().slideUp(0);
    } else {
        $this.html('Hide Details <i class="glyphicon glyphicon-chevron-up"></i>');
        $this.parent().parent().next().removeClass('hide');
        $this.parent().parent().next().slideUp(0);
        $this.parent().parent().next().toggleClass('show');
        $this.parent().parent().next().slideToggle(0);
    }
    // });
});