<div class="modal" tabindex="-1" id="productModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bolder text-black" id="productModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <img id="productModalImage" class="img-responsive" src="" alt="Product Image" width="250">
                    </div>
                    <div class="col-md-5">
                        <p class="fw-bolder fs-2 text-warning" id="productModalPrice"></p>
                        <div>
                            <a href="#" id="decreaseQuantity"><i class="fa-solid fa-circle-minus text-black fs-3"></i></a>
                            <span id="productQuantity" class="fs-3">1</span>
                            <a href="#" id="increaseQuantity"><i class="fa-solid fa-circle-plus text-black fs-3"></i></a>
                        </div>


                    </div>
                </div>
                <div class="row mt-5">
                    <!-- Aquí van las opciones de salsas y extras -->
                    <div class="col-4">
                        <p id="saucesTitle" class="fs-4 fw-bolder">Salsa</p>
                        <div id="saucesContainer">
                            <!-- Aquí van los radio buttons de las salsas -->
                        </div>
                    </div>
                    <div class="col-4">
                        <p id="extrasTitle1" class="fs-4 fw-bolder">Extra 1</p>
                        <div id="extrasContainer1">
                            <!-- Aquí van los checkboxes de los extras -->
                        </div>
                    </div>
                    <div class="col-4">
                        <p id="extrasTitle2" class="fs-4 fw-bolder">Extra 2</p>
                        <div id="extrasContainer2">
                            <!-- Aquí van los checkboxes de los extras -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="customizeErrorMessage" class="alert alert-danger" style="display: none;"></div>
                </div>
                <div class="row">
                    <div class="d-grid gap-1 col-12 mx-auto">
                        <button type="button" class="btn btn-primary noroundborder fw-bold mt-3 text-uppercase" id="addToCartButton" data-product-id="" data-is-editing="false">Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>