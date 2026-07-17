$(document).ready(function () {

    "use strict";

    $('.button_update').click(function () {
        $(this).attr('disabled', 'disabled');
        $(this).html('<span class="fa fa-spinner fa-spin"></span> Loading...');
    })

    $("#search-box").on("input", function () {
        if ($(this).val()) {
            $(this).attr("list", "suggestion");
        } else {
            $(this).removeAttr("list");
        }
    });

    $("#search-box1").on("input", function () {
        if ($(this).val()) {
            $(this).attr("list", "suggestion1");
        } else {
            $(this).removeAttr("list");
        }
    });

    $(".btn-remove-item").click(function () {
        if (window.confirm("Are you sure want to remove this product ?")) {
            $("#hiddenFieldDeleteItemId").val($(this).attr('data-remove-id'));
            $("#frmDeleteItem").submit();
            $(this).attr("disabled", "disabled");
            $(this).html(
                '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>'
            );
        }
    });

    $(".wishlist").click(function () {
        $('#txtProductId').val($(this).attr('data-p-id'));
        $('#txtColorId').val($(this).attr('data-c-id'));
        $('#txtSizeId').val($(this).attr('data-s-id'));
        $(this).attr('disabled', 'disabled');
        $(this).html(
            '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only"></span>');
        $('#frmAddWishlist').submit();
    });

    $(".wishlist-remove").click(function () {
        $('#txtWishlistId').val($(this).attr('data-w-id'));
        $(this).attr('disabled', 'disabled');
        $(this).html(
            '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only"></span>');
        $('#frmRemoveWishlist').submit();
    });

    $(".wishlist-login").click(function () {
        window.location.href = '/myaccount/register';
    });

    $('.search-btn').click(function () {
        $('.searchform').submit();
    });
});

function addToCart(prod_id, stock, c_id, s_id, qty = 1) {
    if (stock > 0) {
        $('#cart_prod_id').val(prod_id);
        $('#cart_qty').val(qty);
        $('#cart_color_id').val(c_id);
        $('#cart_size_id').val(s_id);
        $('#cartForm').submit();
        $(this).html(
            '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>'
        );
    } else {
        swal({
            title: "Out of Stock !",
            text: "Product is currently Out of Stock !",
            type: "warning",
            closeOnConfirm: false
        });
    }
}
