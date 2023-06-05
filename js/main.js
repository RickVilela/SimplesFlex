(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });
    
    // Modal Video
    var $videoSrc;
    $('.btn-play').click(function () {
        $videoSrc = $(this).data("src");
    });
    console.log($videoSrc);
    $('#videoModal').on('shown.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })
    $('#videoModal').on('hide.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc);
    })


    // Project and Testimonial carousel
    $(".project-carousel, .testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: true,
        dots: false,
        nav: true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ],
        responsive: {
			0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

$(".download").on("click" , () =>{

async function download(){
    const { value: email } = await Swal.fire({
        title: 'Informe seu e-mail',
        input: 'email',
        inputLabel: 'Seu e-mail',
        inputPlaceholder: '',
        confirmButtonColor: '#dc3545'
      })
      
      if (email) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: 'success',
            title: 'Obrigado! Download Iniciado'
          })

        window.location.href = "https://www.simplesflex.com.br/download/LSInstall.exe"
      }
}

download();
})

$("#btnEnviarFormulario").on("click", () => {

$( "#assunto" ).on( "change", function() {
        var option = "";
        $( "select option:selected" ).each(function() {
        option += $( this ).text() + " ";
        } );

        let assunto = option;
        let nome = $("#nome").val();
        let email = $("#email").val();
        let celular = $("#celular").val();
        let mensagem = $("#mensagem").val();

console.log(nome, email, celular, assunto, mensagem);

        $.ajax({
            url: "./contato.php",
            type: "POST",
            data: {
                nome: nome, 
                email: email,
                message: mensagem
            },
            dataType: "application/json",
            success: function (response){
                
                console.log(response)
                
                if(response.error == "false"){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                      })
                      
                      Toast.fire({
                        icon: 'success',
                        title: 'Enviado Com Sucesso!'
                      })
                }
                
            },
            error: function(err){
                console.log(err)
            }
            
        })
            
       

  } ).trigger( "change" );

    
})