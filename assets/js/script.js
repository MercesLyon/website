$('#modal-contact').on('submit', 'form', (event) => {
    event.preventDefault()

    const $form = $(event.currentTarget)
    const $container = $form.closest('.modal-content')

    $.post({
        'url': $form.attr('action'),
        'data': $form.serialize(),
        'dataType': 'json'
    }).done((data) => {
        $container.html(data.html)
    })
})

$('.slide-link').on('click', (event) => {
    const scrollTo = $($(event.currentTarget).data('scroll'))

    if (scrollTo.length) {
        event.preventDefault();
        $('html, body').animate({scrollTop: $(scrollTo).offset().top}, 'slow')
    }
})

window.addEventListener('scroll', () => {
    const doc = document.documentElement

    if ((window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0) < 30) {
        $('#main-nav').removeClass('navbar-shrink')
    } else {
        $('#main-nav').addClass('navbar-shrink')
    }
})
