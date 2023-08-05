<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://d31g2a6snus4ly.cloudfront.net/zbooks/assets/styles/vendor-75c709136efc4a0fbd7e4f3e9099e4d5.css">
<div class="card">
  <div class="card-body">
    <div class="container mb-5 mt-3">
      <div class="row d-flex align-items-baseline">
        <div class="col-xl-9">
          <p style="color: #7e8d9f;font-size: 20px;">SALES ORDER >> <strong><?php echo $salesOrders->salesOrderNumber; ?></strong></p>
        </div>
        <div class="col-xl-3 float-end">
          <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
              class="fas fa-print text-primary"></i> Print</a>
          <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i
              class="far fa-file-pdf text-danger"></i> Export</a>
        </div>
        <hr>
      </div>

      <div class="container">


        <div class="row">
          <div class="col-xl-8">
            <ul class="list-unstyled">
              <li class="text-muted">To: <span style="color:#5d9fc5 ;"><?php echo $salesOrders->customerDisplay; ?></span></li>
              <li class="text-muted"><?php echo $bill->address1?></li>
              <li class="text-muted"><?php echo $bill->address2?></li>
              <li class="text-muted"><?php echo $bill->city ?>, <?php echo $bill->state ?> <?php echo $bill->zipCode ?>, 
			  <?php echo $bill->country?></li>
              <li class="text-muted"><i class="fas fa-phone"></i> <?php echo $bill->phone?></li>
              <li class="text-muted"><i class="fas fa-phone"></i> <?php echo $bill->fax?></li>
            </ul>
          </div>
          <div class="col-xl-3">
            <p class="text-muted"></p>
			
			<div class="form-row">
				<div class="col">
				  <span class="text-muted me-3">Reference</span>
				</div>
				<div class="col">
				  #<?php echo $salesOrders->reference; ?>
				</div>
			</div>
			
			<div class="form-row">
				<div class="col">
				  <span class="text-muted me-3">Order Date</span>
				</div>
				<div class="col">
				  <?php echo date("Y-m-d", strtotime($salesOrders->salesOrderDate)); ?>
				</div>
			</div>
			
			<div class="form-row">
				<div class="col">
				  <span class="text-muted me-3">Status</span>
				</div>
				<div class="col">
				<span class="badge bg-warning text-muted fw-bold">
				  <?php echo $salesOrders->status; ?>
				</span>
				</div>
			</div>
			
          </div>
        </div>

        <div class="row my-2 mx-1 justify-content-center">
          <table class="table table-striped table-borderless">
            <thead style="background-color:#84B0CA ;" class="text-white">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Item & Description</th>
                <th scope="col">Qty</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Amount</th>
              </tr>
            </thead>
            <tbody>
			<?php foreach($salesOrdersDetails as $key => $salesDetails) { ?>
              <tr>
                <th scope="row"><?php echo $key+1 ?></th>
                <td><?php echo $salesDetails->productName ?></td>
                <td><?php echo $salesDetails->quantity ?></td>
                <td><?php echo \FormatCurrency($salesDetails->priceSell) ?></td>
                <td><?php echo \FormatCurrency($salesDetails->amount) ?></td>
              </tr>
			<?php } ?>
            </tbody>

          </table>
        </div>
        <div class="row">
		
          <div class="col-xl-8">
			<div class="card" style="width: 350px;">
			  <div class="card-body py-2">
				<p class="card-title"><strong>Notes</strong></p>
				<p class="card-text"><?php echo $salesOrders->remark; ?></p>
			  </div>
			</div>
          </div>
          <div class="col-xl-4 text-muted ms-3">
		  
			<!-- TOTAL AMOUNT -->
			<?php foreach($salesOrdersAmount as $keyAmount => $salesAmount) { ?>
				<?php if($salesAmount->value != 0) { ?>
					<div class="form-row">
						<div class="col">
						  <span class="text-black me-4"><?php echo $salesAmount->title ?></span>
						</div>
						<div class="col">
						  <?php echo \FormatCurrency($salesAmount->value) ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			
			<hr>
			<div class="form-row float-start">
				<div class="col">
				  <span class="text-black me-4">Total Amount</span>
				</div>
				<div class="col">
				  <?php echo \FormatCurrency($salesOrders->totalAmount) ?>
				</div>
			</div>
			<!-- TOTAL AMOUNT EOF-->
  
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xl-10">
            <p>Thank you for your purchase</p>
          </div>
          <div class="col-xl-2">
            <button type="button" class="btn btn-primary text-capitalize"
              style="background-color:#60bdf3 ;">Pay Now</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>