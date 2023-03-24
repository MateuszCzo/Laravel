window.onload = () => {
    $('button.add-cart-button').click(addProductToCart);

    $('div.products-count a').click(function(event) {
        event.preventDefault();
        $('a.products-actual-count').text($(this).text());
        getProducts($(this).text());
    });

    $('a#search').click(function(event) {
        event.preventDefault();
        getProducts($('a.products-actual-count').first().text());
    })

    function getProducts(paginate) {
        const form = $('form.sidebar-filter').serialize();
        $.ajax({
            method: 'GET',
            url: "/",
            data: form + "&" + $.param({paginate: paginate})
        })
        .done(function(response) {
            $('div#products-wrapper').empty();
            $.each(response.data, function(index, product) {
                const html = '<div class="col-6 col-md-6 col-lg-4 mb-3">' +
                                '<div class="card h-100 border-0">' +
                                    '<div class="card-img-top">' +
                                        '<img src="' + getImage(product) + '" class="img-fluid mx-auto d-block" alt="Zdjęcie produktu">' +
                                    '</div>' +
                                    '<div class="card-body text-center">' +
                                        '<h4 class="card-title">' +
                                            product.name +
                                        '</h4>' +
                                        '<h5 class="card-price small">' +
                                            '<i>PLN ' + product.price + '</i>' +
                                        '</h5>' +
                                    '</div>' +
                                    '<button class="btn btn-success btn-sm add-cart-button" ' + getDisabled() + ' data-id="' + product.id + '" >' +
                                        '<i class="bi bi-cart4" ></i> Dodaj do koszyka' +
                                    '</button>' +
                                '</div>' +
                            '</div>';
                $('div#products-wrapper').append(html);
            });
            $('button.add-cart-button').click(addProductToCart);
        })
        .fail(function(response) {
            alert("Error");
        });
    }

    function addProductToCart() {
        $.ajax({
            method: 'POST',
            url: WELCOME_DATA.addToCart + $(this).data('id')
        })
        .done(function() {
            Swal.fire({
                title: 'Brawo!',
                text: 'Produkt dodany do koszyka',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '<i class="bi bi-basket3"></i> Kontynuuj zakupy',
                confirmButtonText: '<i class="bi bi-cart4"></i> Przejdz do koszyka',
            }).then((result) => {
                if (!result.isConfirmed) return;
                window.location = WELCOME_DATA.listCart;
            });
        })
        .fail(function() { 
            Swal.fire('Oops...', 'Wystapil blad', 'error');
        })
    }

    function getImage(product) {
        if(!!product.image_path) return WELCOME_DATA.storagePath + product.image_path;
        return WELCOME_DATA.defaultImage;
    }

    function getDisabled() {
        if(WELCOME_DATA.isGuest) return ' disabled';
        return '';
    }
}