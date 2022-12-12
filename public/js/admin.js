$(document).ready(function() {

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    // Editors
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link charmap hr anchor pagebreak',
        toolbar_mode: 'floating',
        language: 'fr_FR',
        menubar: false
    });

    // Labels
    $('label').each(function() {
        const text = $(this).text();
        $(this).text(text + ' :');
    });

    // Relai
    const relaiWidget = $('#relaiWidget');

    if (relaiWidget.length > 0) {
        relaiWidget.MR_ParcelShopPicker({
            Target: '#relaiWidget',
            TargetDisplay: '#relaiWidgetDisplay',
            TargetDisplayInfoPR: '#relaiWidgetDisplayInformations',
            Brand: 'BDTOPMOU',
            Country: 'FR',
            PostCode: $('#postalCode').val(),
            ColLivMod: $('#volume').val(),
            NbResults: '7',
            DisplayMapInfo: true,
            OnParcelShopSelected: function (data) {
                $('#relaiWidgetId').html(data.ID);
                $('#relaiWidgetName').html(data.Nom);
                $('#relaiWidgetAddress').html(data.Adresse1);
                $('#relaiWidgetPostalCode').html(data.CP);
                $('#relaiWidgetCity').html(data.Ville);
                $('#relaiWidgetCountry').html(data.Pays);

                $('#update_shipping_address_shippingAddress').val(data.Nom + ' ' + data.Adresse1);
                $('#update_shipping_address_shippingPostalCode').val(data.CP);
                $('#update_shipping_address_shippingCity').val(data.Ville);
                $('#update_shipping_address_shippingCode').val(data.ID);
            }
        });
    }
});