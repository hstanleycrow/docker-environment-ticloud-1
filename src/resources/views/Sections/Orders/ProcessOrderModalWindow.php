<div class="modal" tabindex="-1" id="orderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bolder text-black" id="orderModalTitle">Total a cancelar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="fw-bolder fs-2 text-warning" id="orderModalTotal"></p>
                        <p>Complete la(s) forma(s) de pago:</p>
                        <div>
                            <? foreach ($paymentMethods as $paymentMethod) : ?>
                                <div class="d-flex row">
                                    <div class="col-8 d-flex align-items-center">
                                        <label class="form-check-label fw-bold" for="amount_<?= slug($paymentMethod['name']); ?>">
                                            &nbsp;<?= $paymentMethod['name']; ?>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control payment-amount" id="amount_<?= slug($paymentMethod['name']); ?>" name="amount_<?= $paymentMethod['id']; ?>" min="0" step="0.01" lang="en">
                                    </div>
                                </div>
                            <? endforeach; ?>
                            <div class="d-flex row">
                                <div class="col-8 d-flex align-items-center">
                                    <label class="form-check-label fw-bold" for="total_amount">
                                        &nbsp;Total
                                    </label>
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control payment-amount" id="total_amount" name="total_amount" min="0" step="0.01" lang="en" readonly>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-bold" for="notes">Notas del pedido:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <div class="d-grid gap-1 col-12 mx-auto">
                            <button type="button" class="btn btn-danger noroundborder fw-bold mt-3 text-uppercase" id="processOrderButton">Procesar Pedido</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>