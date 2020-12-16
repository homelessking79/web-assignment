<style>
    .search{
        /* display: inline-block !important; */
        position: relative;
    }
  

    .search-result {
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
    }

    .search-result p {
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
        background-color: white;
    }
    .search-result p:hover{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
        background-color: #041525;
        color: white;
    }
    
</style>
<div class="ml-4 navbar-nav search">
    <form class="form-inline">
        <input class="form-control mr-sm-2 search-box" type="text" placeholder="Search" aria-label="Search" style="border:none;">
    </form>
    <div class="search-result"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.search-box').on("keyup", function() {
            console.log("ok");
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(".search-result");
            if (inputVal.length) {
                $.get("./scripts/foreground/searchProduct.php", {
                    term: inputVal
                }).done(function(data) {
                    // Display the returned data in browser
                    console.log("ok lah" + data);

                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });

        // // Set search input value on click of result item
        // $(document).on("click", ".result p", function() {
        //     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        //     $(this).parent(".result").empty();
        // });
    });

    $(document).on('click', '.product_detail', function() {
        id = $(this).attr('id');
        console.log("ok");
        localStorage.setItem('product-id', parseInt(id) );
        window.open("./product_detail.php", "_self");
      });
</script>