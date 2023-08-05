<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://d31g2a6snus4ly.cloudfront.net/zbooks/assets/styles/vendor-75c709136efc4a0fbd7e4f3e9099e4d5.css">
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #FAFAFA;
  font: 12pt "Tahoma";
}

* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.page {
  width: 21cm;
  min-height: 29.7cm;
  padding: 1cm;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.subpage {
  padding: 1cm;
  border: 5px grey solid;
  height: 256mm;
}

@page {
  size: A4;
  margin: 0;
}

@media print {
  .page {
    margin: 0;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>
<div class="book">
  <div class="page"><div class="subpage">
	<div class="">
   <div class="row">
      <div class="col-lg-7 col-md-6">
         <div>
            <h3 class="text-uppercase">
               <span class="text-regular">Sales Order</span> 
               <span id="ember985" class="ember-view">
                  <!---->
               </span>
            </h3>
            <div class="so-number"><label class="font-small">Sales Order#</label> <label class="font-small"><strong>SO-00002</strong></label></div>
            <h6 class="text-uppercase"><strong>Status</strong></h6>
            <div class="status-block px-4">
               <div class="order-status row"><label class="col-lg-3">Order</label> <span id="ember986" class="tooltip-container ember-view col-lg-7"><label class="text-uppercase text-semibold badge badge-so badge-open">Confirmed</label></span></div>
               <div class="row"><label class="col-lg-3">Invoice</label> <label class="col-lg-7 text-draft">Not Invoiced</label></div>
               <div class="row"><label class="col-lg-3">Payment</label> <label class="col-lg-7 text-fulfilled">Unpaid</label></div>
               <div class="row"><label class="col-lg-3">Shipment</label> <label class="col-lg-7 text-pending">Pending</label></div>
            </div>
         </div>
         <div class="order-info">
            <!----> 
            <div class="row">
               <div class="col-lg-4">
                  <h6 class="text-uppercase"><strong>Order Date</strong></h6>
               </div>
               <div class="col-lg-6 so-details-label">25/08/2022</div>
            </div>
            <div class="row">
               <div class="col-lg-4">
                  <h6 class="text-uppercase"><strong>Expected Shipment Date</strong></h6>
               </div>
               <div class="col-lg-6 so-details-label">25/08/2022</div>
            </div>
            <div class="row">
               <div class="col-lg-4">
                  <h6 class="text-uppercase"><strong>Payment Terms</strong></h6>
               </div>
               <div class="col-lg-6 so-details-label">Due on Receipt</div>
            </div>
            <!----><!----><!----><!----><!----> 
         </div>
      </div>
      <div class="col-lg-5 col-md-6">
         <div class="address">
            <!----> 
            <h6 class="text-uppercase"><strong>Billing Address</strong></h6>
            <label><a id="ember987" class="ember-view" href="#/contacts/3441822000000075208">test</a></label> 
            <address>
               <!----> 1 Jl rengas bandung <br> Rengas bandung raya <br> Bekasi,  Jawa  <br> Indonesia   - 17550  <br> 085718159655   
            </address>
            <div class="address">
               <h6 class="text-uppercase"><strong>Shipping Address</strong></h6>
               <address>
                  <!----> Bekasi <br> Bekasi timur <br> Bekasi,  Jawa  <br> Indonesia   - 17550  <br> 085718159655  
               </address>
            </div>
         </div>
         <!----> 
      </div>
      <!----> 
   </div>
   <!----> 
   <table class="table zi-table details-page-table so-details-table">
      <thead>
         <tr style="font-size: 12px">
            <th width="28%">Items &amp; Description</th>
            <th width="10%">Ordered</th>
            <th width="16%">Warehouse Name</th>
            <th class="pl-4" width="17%">Status</th>
            <th class="text-right" width="12%">Rate</th>
            <th class="text-right" width="20%">Amount</th>
         </tr>
      </thead>
      <tbody>
         <tr style="font-size: 12px">
            <td>
               <div class="row">
                  <div class="col-lg-3">
                     <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="icon icon-picture d-block m-auto">
                        <path d="M64 439.1V388c0-3.2 1-6.3 2.7-9l56.2-83.2c3.1-4.6 9.3-5.8 13.8-2.7l80.9 53.9c4 2.6 9.2 2.1 12.6-1.2l115.1-115.1c3.9-3.9 10.2-3.9 14.1 0l83.8 83.7c3 3 4.8 7.1 4.8 11.3v113.4c0 4.4-3.8 8-8.2 8H72c-4.4 0-8-3.6-8-8z"></path>
                        <circle cx="208" cy="239.1" r="48"></circle>
                        <path d="M0 159.1v320.5c0 17.7 14.3 32 32 32l448-.4c17.7 0 32-14.3 32-32V159.1c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32zm464 320H48c-8.8 0-16-7.2-16-16v-288c0-8.8 7.2-16 16-16h416c8.8 0 16 7.2 16 16v288c0 8.8-7.2 16-16 16z"></path>
                     </svg>
                  </div>
                  <div class="col-lg-9">
                     <div id="ember990" class="ember-view">
                        <span class="btn-link cursor-pointer"> LAPTOP </span>  
                        <div id="ember991" class="ember-view">
                           <div id="ember992" class="ember-view"></div>
                        </div>
                     </div>
                     <div class="font-small text-muted">SKU: 12346</div>
                     <br> <small class="text-muted wrap"></small>
                  </div>
               </div>
            </td>
            <td>
               100 
               <div class="font-xxs text-muted">pcs</div>
            </td>
            <td>PRODUCTION</td>
            <td class="pl-4 notfulfilled-lineitem">
               <p><span class="font-medium">0</span>&nbsp;&nbsp;Packed</p>
               <!----><!----><!---->
               <p><span class="font-medium">0</span>&nbsp;&nbsp;Invoiced</p>
               <!---->
            </td>
            <td class="text-right">IDR100,000.00</td>
            <!----> 
            <td class="text-right">  IDR10,000,000.00  </td>
         </tr>
      </tbody>
   </table>
   <div class="group">
      <div class="row">
         <div class="col-lg-6 col-md-9 ml-auto">
            <div class="sub-total-section">
               <div class="row">
                  <div class="col-lg-6 col-md-6">
                     <strong>Sub Total</strong> 
                     <div class="font-xs text-muted">Total Quantity : 100</div>
                     <!----> 
                  </div>
                  <div class="col-lg-6 col-md-6 over-flow"><strong>  IDR10,000,000.00  </strong></div>
               </div>
               <!----> 
               <div class="row text-muted">
                  <div class="col-lg-6 col-md-6">Discount </div>
                  <div class="col-lg-6 col-md-6 over-flow">IDR0.00</div>
               </div>
               <!----> <!----> <!----> <!----> <!----> 
            </div>
            <div class="row total-section mx-0">
               <div class="col-lg-6 col-md-6">Total</div>
               <div class="col-lg-6 col-md-6 over-flow">IDR10,000,000.00</div>
            </div>
         </div>
      </div>
      <!----> <br> <!----> 
   </div>
</div>
    Page 1/2</div>
  </div>
  <div class="page">
    <div class="subpage">Page 2/2</div>
  </div>
</div>
