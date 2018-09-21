<div class="clearfix"></div>
<aside class="bg-dark wow fadeOut" data-wow-duration="3s">
    <div class="container text-center">
      <div class="call-to-action">
        <div class="row">
          <div class="col-md-12" id="footer1">
          </div>
        </div>
      </div>
    </div>
</aside>
<section class="no-padding" id="contact">
    <footer>
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-4" id="footer-third">
            <section class="one-third wow bounceInLeft" data-wow-duration="3s">
              <h3>Contact Us</h3>
                <p class="footercontact">
                    Ajay Kumar Yadav<br>
                    <b class="phone">01687430392</b><br>
                    Khulna University Khulna-9208<br>
                    <b>Bangladesh</b>
                </p>
            </section>
          </div>
          <div class="col-md-4" id="footer-third">
            <section class="wow bounceInDown" data-wow-duration="3s"">
            <h3>Social</h3>
              <ul class="social">
                <li>
                  <a href="https://www.facebook.com/ajaycse11" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="https://www.instagram.com/meajaykryadav/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
              </ul> 
            </section>
          </div>
          <div class="col-md-4" id="footer-third-last">
            <section class="wow bounceInRight" data-wow-duration="3s" id="one-third">
              <h3>Pages</h3>
              <h5 id="footer-third3">
                <a href="">Home</a> -
                <a href="">About</a> -
                <a href="">Contact</a>
              </h5>
            </section>                  
          </div>
        </div>
    </div>
    </footer>
    <footer class="second">
        <p class="wow bounceInRight" data-wow-duration="3s"> Copyright <i class="fa fa-copyright" aria-hidden="true"></i> 2017-2018 All Rights Reserved. </p>
    </footer>
</section>
<script src="js/wow.min.js"></script>
<script>
        new WOW().init();
</script>

<script type="text/javascript">
   
 </script>

<style>
    footer {
        background: #333;
        overflow: hidden;
        opacity: .9;
    }
    #footer-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    footer .one-third {
        width: 100%;
        margin: 2% 0;   
    }
    footer h3 {
        color: #F0F0F0;
    }
    footer p {
        color: #F0F0F0;
        text-align: center;
    }
    #footer-third {
        border-right: 1px solid #959595;
    }
    footer a {
        color: #959595;
        font-size: 110%;
        text-decoration: none;
    }
    .social li {
        display: inline;
    }
    .social i {
        font-size: 245%;
        padding: 2% 6%;
        color: #959595;
    }
    .social i:hover {
        color: #F5F5F5;
    }
    h5 a:hover {
        text-decoration: none;
        color: #F0F0F0;
    }
/*---Start Second Footer---*/
footer.second {
    border-top: 1px solid #4D4E50;
    max-height: 50px;
    padding-top: 1%;
    opacity: .95;
}

</style>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
</script>
    <script>

        function detailsmodal(id){
            var data = {"id" : id};
            jQuery.ajax({
                url : '/E-commerce/includes/detailsmodal.php',
                method : "post",
                data : data,
                success: function(data){
                    jQuery('body').append(data);
                    jQuery('#details-modal').modal('toggle');
                },

                error: function(){ 
                    alert("Something went wrong!");
                }
            });
        

        function update_cart(mode,edit_id,edit_size){
            var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
            jQuery.ajax({
                url : '/E-commerce/admin/parsers/update_cart.php',
                method : "post",
                data : data,
                success : function(){location.reload();},
                error : function(){alert("Something went wrong");},
            });
        }

        function add_to_cart(){
            jQuery('#modal_errors').html("");
            var size = jQuery('#size').val();
            var quantity = jQuery('#quantity').val();
            var available = jQuery('#available').val();
            var error = '';
            var data = jQuery('#add_product_form').serialize();
            if(size == '' || quantity == '' || quantity == 0){
                error += '<div class="alert alert-danger" role="alert"><strong>You!</strong> must choose a size and quantity.</div>';
                jQuery('#modal_errors').html(error);
                return;
            }else if(quantity > available){
                error += '<div class="alert alert-danger" role="alert">There are only <strong>'+available+'</strong> available.</div>';
                jQuery('#modal_errors').html(error);
                return;
            }else{
                jQuery.ajax({
                    url : '/E-commerce/admin/parsers/add_cart.php',
                    method : 'post',
                    data : data,
                    success : function(){
                        location.reload();
                    },
                    error : function(){
                        alert("Something went wrong.!");
                    }
                });
            }
        }

    </script>

    <script>

$('.slider1').bxSlider({
    mode: 'fade',
    captions: false,
    auto: true,
    pager: false,

});
$('.slider2').bxSlider({
    pager: false,
    captions: true,
    maxSlides: 3,
    minSlides: 1,
    slideWidth: 230,
    slideMargin: 10
});
$('.slider3').bxSlider({
    mode: 'fade',
    captions: false,
    auto: true,
    pager: false,
    controls: false,
});

</script>
</body>
</html>