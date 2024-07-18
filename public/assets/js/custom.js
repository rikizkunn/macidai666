$(function () {
    "use strict";

    // Feather Icon Init Js
    // feather.replace();

    // $(".preloader").fadeOut();

    // =================================
    // Tooltip
    // =================================
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // =================================
    // Popover
    // =================================
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // increment & decrement
    $(".minus,.add").on("click", function () {
        var $qty = $(this).closest("div").find(".qty"),
            currentVal = parseInt($qty.val()),
            isAdd = $(this).hasClass("add");
        !isNaN(currentVal) &&
            $qty.val(
                isAdd
                    ? ++currentVal
                    : currentVal > 0
                    ? --currentVal
                    : currentVal
            );
    });

    // ==============================================================
    // Collapsable cards
    // ==============================================================
    $('a[data-action="collapse"]').on("click", function (e) {
        e.preventDefault();
        $(this)
            .closest(".card")
            .find('[data-action="collapse"] i')
            .toggleClass("ti-minus ti-plus");
        $(this).closest(".card").children(".card-body").collapse("toggle");
    });
    // Toggle fullscreen
    $('a[data-action="expand"]').on("click", function (e) {
        e.preventDefault();
        $(this)
            .closest(".card")
            .find('[data-action="expand"] i')
            .toggleClass("ti-arrows-maximize ti-arrows-maximize");
        $(this).closest(".card").toggleClass("card-fullscreen");
    });
    // Close Card
    $('a[data-action="close"]').on("click", function () {
        $(this).closest(".card").removeClass().slideUp("fast");
    });

    // fixed header
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 60) {
            $(".app-header").addClass("fixed-header");
        } else {
            $(".app-header").removeClass("fixed-header");
        }
    });

    // Checkout
    $(function () {
        $(".billing-address").click(function () {
            $(".billing-address-content").hide();
        });
        $(".billing-address").click(function () {
            $(".payment-method-list").show();
        });
    });
});

/*change layout boxed/full */
$(".full-width").click(function () {
    $(".container-fluid").addClass("mw-100");
    $(".full-width i").addClass("text-primary");
    $(".boxed-width i").removeClass("text-primary");
});
$(".boxed-width").click(function () {
    $(".container-fluid").removeClass("mw-100");
    $(".full-width i").removeClass("text-primary");
    $(".boxed-width i").addClass("text-primary");
});

/*Dark/Light theme*/
$(".light-logo").hide();
$(".dark-theme").click(function () {
    $("nav.navbar-light").addClass("navbar-dark");
    $(".dark-theme i").addClass("text-primary");
    $(".light-theme i").removeClass("text-primary");
    $(".light-logo").show();
    $(".dark-logo").hide();
});
$(".light-theme").click(function () {
    $("nav.navbar-light").removeClass("navbar-dark");
    $(".dark-theme i").removeClass("text-primary");
    $(".light-theme i").addClass("text-primary");
    $(".light-logo").hide();
    $(".dark-logo").show();
});

/*Card border/shadow*/
$(".cardborder").click(function () {
    $("body").addClass("cardwithborder");
    $(".cardshadow i").addClass("text-dark");
    $(".cardborder i").addClass("text-primary");
});
$(".cardshadow").click(function () {
    $("body").removeClass("cardwithborder");
    $(".cardborder i").removeClass("text-primary");
    $(".cardshadow i").removeClass("text-dark");
});

$(".change-colors li a").click(function () {
    $(".change-colors li a").removeClass("active-theme");
    $(this).addClass("active-theme");
});

$(document).ready(function () {
    var form = $(".tab-wizard-checkout");

    form.steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit",
            next: "Next",
            previous: "Previous",
        },
        onFinishing: function (event, currentIndex) {
            // Validate the form before submission
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            // Use AJAX to submit the form
            var formData = form.serialize();
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: formData,
                success: function (response) {
                    toastr.success(
                        "Order Success Redirecting..",
                        "Redirecting..",
                        {
                            progressBar: true,
                            timeOut: 2000,
                            preventDuplicates: true,
                            onHidden: function () {
                                window.location.href = "/transaction";
                            },
                        }
                    );
                    // Handle success response
                    // window.location.replace("/transaction");
                    console.log("success");
                },
                error: function (error) {
                    console.log("error");
                },
            });
        },
    });

    // Optionally add validation rules if necessary
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            // Define validation rules
        },
    });
});

$(document).ready(function () {
    $("#create-product").click(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        var productDescription = tinymce.get("mymce").getContent();

        var formData = new FormData();
        formData.append("product_name", $('input[name="product_name"]').val());
        formData.append("brand", $('input[name="brand"]').val());
        formData.append("product_description", productDescription);
        formData.append(
            "product_image",
            $('input[name="product_image"]')[0].files[0]
        );
        formData.append("price", $('input[name="price"]').val());
        formData.append("categories", $('select[name="categories"]').val());
        formData.append("option", $('input[name="option"]').val());
        formData.append("stock", $('input[name="stock"]').val());

        // AJAX request
        $.ajax({
            url: "/product/store",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: formData,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (response) {
                // Handle success
                toastr.success(
                    "Product Has Been Succesfully Saved ",
                    "Redirecting..",
                    {
                        progressBar: true,
                        timeOut: 3000,
                        preventDuplicates: true,
                        onHidden: function () {
                            window.location.href = "/products";
                        },
                    }
                );
            },
            error: function (response) {
                // Handle error
                toastr.error("An error occurred while saving the product.");
            },
        });
    });

    // Handle cancel button click
    $('button[type="button"]').click(function () {
        // Reset form fields or perform any other action on cancel
        $("form")[0].reset();
    });
});

$(document).ready(function () {
    $("#update-product").click(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        let csrfToken = $('meta[name="csrf-token"]').attr("content");
        var productDescription = tinymce.get("mymce").getContent();

        var formData = new FormData();
        formData.append("product_name", $('input[name="product_name"]').val());
        formData.append("brand", $('input[name="brand"]').val());
        formData.append("product_id", $('input[name="product_id"]').val());
        formData.append("product_description", productDescription);
        var productImageInput = $('input[name="product_image"]')[0];
        if (productImageInput.files.length > 0) {
            formData.append("product_image", productImageInput.files[0]);
        }
        formData.append("price", $('input[name="price"]').val());
        formData.append("categories", $('select[name="categories"]').val());
        formData.append("option", $('input[name="option"]').val());
        formData.append("stock", $('input[name="stock"]').val());

        // AJAX request
        $.ajax({
            url: "/product/update", // Update the URL to your update route
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: formData,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (response) {
                // Handle success
                toastr.success(
                    "Product has been successfully updated!",
                    "Redirecting..",
                    {
                        progressBar: true,
                        timeOut: 3000,
                        preventDuplicates: true,
                        onHidden: function () {
                            window.location.href = "/product/show";
                        },
                    }
                );
            },
            error: function (response) {
                // Handle error
                toastr.error("An error occurred while updating the product.");
            },
        });
    });

    // Handle cancel button click
    $('button[type="button"]').click(function () {
        // Reset form fields or perform any other action on cancel
        $("form")[0].reset();
    });
});

$(document).ready(function () {
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    var table = $("#zero_config").DataTable(); // Initialize your DataTable

    $(document).on("click", ".delete-product", function () {
        var productId = $(this).data("product-id");
        var row = $(this).closest("tr"); // Get the row to remove

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/product/delete",
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        product_id: productId,
                    },
                    success: function (response) {
                        Swal.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );

                        table.row(row).remove().draw(); // Remove the row from the DataTable
                    },
                    error: function (response) {
                        Swal.fire(
                            "Error!",
                            "An error occurred while deleting the product.",
                            "error"
                        );
                    },
                });
            }
        });
    });
});

$(document).on("click", "#add-cart", function () {
    // Assuming you have a product ID to add
    let productId = $(this).data("product-id");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let quantity = $(".qty").val(); // Get the quantity from the input field
    // console.log(productId);
    $.ajax({
        type: "POST",
        url: "/cart/add",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: JSON.stringify({ product_id: productId, quantity: quantity }),
        contentType: "application/json",
        success: function (response) {
            // Assuming response contains a message and status
            if (response.status) {
                toastr.success("Product Added to cart", "Success");
            } else {
                toastr.error(
                    "There was an error adding the product to the cart",
                    "Error"
                );
            }
        },
        error: function () {
            toastr.error(
                "There was an error adding the product to the cart.",
                "Error"
            );
        },
    });
});

$(document).on("click", "#buy-now", function () {
    // Assuming you have a product ID to add
    let productId = $(this).data("product-id");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let quantity = $(".qty").val();
    $.ajax({
        type: "POST",
        url: "/cart/add",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: JSON.stringify({ product_id: productId, quantity: quantity }),
        contentType: "application/json",
        success: function (response) {
            // Assuming response contains a message and status
            if (response.status) {
                window.location.replace("/cart/show");

                toastr.success("Redirecting to checkout page", "Success");
            } else {
                toastr.error("There was an error buying the product", "Error");
            }
        },
        error: function () {
            toastr.error("There was an error buying the products.", "Error");
        },
    });
});

$(document).on("click", "#delete-product", function () {
    // Assuming you have a product ID to add
    let productId = $(this).data("product-id");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        type: "POST",
        url: "/cart/destroy",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        data: JSON.stringify({ product_id: productId }),
        contentType: "application/json",
        success: function (response) {
            // Assuming response contains a message and status
            if (response.status) {
                $('tr[data-product-id="' + productId + '"]').remove();
                toastr.success("Product deleted from cart", "Success");
                $(".cart-total").text("IDR " + response.cart_total); // Update the cart total display
            } else {
                toastr.error(
                    "There was an error delete the product to the cart.",
                    "Error"
                );
            }
        },
        error: function () {
            toastr.error(
                "There was an error delete the product to the cart.",
                "Error"
            );
        },
    });
});

function updateCart(productId, quantity) {
    // Get CSRF token from meta tag
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        type: "POST",
        url: "/cart/update",
        headers: {
            "X-CSRF-TOKEN": csrfToken, // Include CSRF token in the request headers
        },
        data: {
            product_id: productId,
            quantity: quantity,
        },
        success: function (response) {
            if (response.status) {
                toastr.success("Cart updated successfully", "Success");
                $(".cart-total").text("IDR " + response.cart_total); // Update the cart total display
                // Optionally update other parts of the UI if needed
            } else {
                console.log(response.status);
                toastr.error("Failed to update cart", "Error");
            }
        },
        error: function () {
            toastr.error("There was an error updating the cart.", "Error");
        },
    });
}
// Handle click event for decrease button
$(document).on("click", "#decrease", function () {
    let productId = $(this).data("product-id");
    let quantityInput = $(this).siblings(".qty");
    let currentValue = parseInt(quantityInput.val());

    if (currentValue > 1) {
        currentValue--;
        quantityInput.val(currentValue);
        updateCart(productId, currentValue);
    }
});

// Handle click event for increase button
$(document).on("click", "#increase", function () {
    let productId = $(this).data("product-id");
    let quantityInput = $(this).siblings(".qty");
    let currentValue = parseInt(quantityInput.val());

    currentValue++;
    quantityInput.val(currentValue);
    updateCart(productId, currentValue);
});

// Optionally, handle manual input changes
$(document).on("change", ".qty", function () {
    let productId = $(this).siblings("button").data("product-id");
    let newQuantity = parseInt($(this).val());

    if (newQuantity > 0) {
        updateCart(productId, newQuantity);
    } else {
        $(this).val(1);
        updateCart(productId, 1);
    }
});

/*Theme color change*/
function toggleTheme(value) {
    $(".preloader").show();
    var sheets = document.getElementById("themeColors");
    sheets.href = value;
    $(".preloader").fadeOut();
}
$(".preloader").fadeOut();
