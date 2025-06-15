import{f as r,a as d}from"./format-B7a5NblC.js";class c{constructor(){this.datatableEl=$("#datatables"),this.soSelectEl=$("#selectSalesOrder"),this.detailWrapper=document.getElementById("so-details-wrapper"),this.areaSelectEls=$("#origin, #destination"),this.btnCekOngkir=document.getElementById("btnCekOngkir"),this.soUrl=$("#so-select-wrapper").data("get-sales-order-url"),this.soDetailTpl=$("#so-select-wrapper").data("get-sales-order-detail-url"),this.areaUrl=$("#area-wrapper").data("area-url"),this.cekOngkirUrl=$("#area-wrapper").data("cek-ongkir-url")}initIndex(){console.log("Halaman Transaksi DO Index berhasil dimuat!"),this.initDataTable()}initShow(){console.log("Halaman Transaksi DO Show berhasil dimuat!")}initCreate(){console.log("Halaman Transaksi DO Create berhasil dimuat!"),this.initForm()}initEdit(){console.log("Halaman Transaksi DO Edit berhasil dimuat!"),this.initForm()}initDataTable(){const a=this.datatableEl.data("url");this.datatableEl.DataTable({processing:!0,serverSide:!0,ajax:a,columns:[{data:"DT_RowIndex",name:"DT_RowIndex",className:"text-center",orderable:!1,searchable:!1},{data:"no_do",name:"no_do",className:"text-center"},{data:"no_so",name:"no_so",className:"text-center"},{data:"tanggal",name:"tanggal",className:"text-center"},{data:"customer",name:"customer"},{data:"metode_pembayaran",name:"metode_pembayaran",className:"text-center"},{data:"total_qty",name:"total_qty",className:"text-end"},{data:"total_diskon",name:"total_diskon",className:"text-end",render:$.fn.dataTable.render.number(".",",",0,"Rp ")},{data:"grand_total",name:"grand_total",className:"text-end fw-bold",render:$.fn.dataTable.render.number(".",",",0,"Rp ")},{data:"approval_level",name:"approval_level"},{data:"status",name:"status"},{data:"keterangan",name:"keterangan"},{data:null,orderable:!1,searchable:!1,className:"text-center no-export",render:function(n,l,t){let s="";return t.can_show&&(s+=`
                <a href="${t.show_url}" class="btn btn-sm rounded-4 btn-info" data-bs-toggle="tooltip" title="Detail">
                    <i class="bi bi-eye-fill"></i>
                </a>
            `),t.approval_level==t.approval_sequence-1&&t.status!=="Rejected"&&(t.approval_level==0?s+=`
                    <form action="${t.approve_url}" method="POST" class="d-inline form-approval">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                        <button type="submit" class="btn btn-sm rounded-4 btn-success btn-approve" data-bs-toggle="tooltip" title="Ajukan">
                            <i class="bi bi-check2-square"></i>
                        </button>
                    </form>
                `:s+=`
                    <div class="dropdown dropstart d-inline">
                        <button class="btn btn-sm rounded-4 btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" title="Action">
                            <i class="bi bi-gear-fill"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="${t.revisi_url}" method="POST" class="form-revisi">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                                    <button type="submit" class="dropdown-item text-warning btn-revisi">
                                        <i class="bi bi-arrow-clockwise"></i> Revisi
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="${t.approve_url}" method="POST" class="form-approval">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                                    <button type="submit" class="dropdown-item text-success btn-approve">
                                        <i class="bi bi-check2-square"></i> Approve
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="${t.reject_url}" method="POST" class="form-reject">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                                    <button type="button" class="dropdown-item text-danger btn-reject">
                                        <i class="bi bi-x-square-fill"></i> Reject
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                `),t.approval_level==0&&(t.can_edit&&(s+=`
                    <a href="${t.edit_url}" class="btn btn-sm rounded-4 btn-warning" data-bs-toggle="tooltip" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                `),t.can_delete&&(s+=`
                    <form action="${t.delete_url}" method="POST" class="d-inline form-delete">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-sm rounded-4 btn-danger btn-delete" data-bs-toggle="tooltip" title="Hapus">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                `)),`<div class="d-flex justify-content-center gap-1 flex-wrap">${s}</div>`}}],dom:"<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center align-items-center'><'col-sm-12 col-md-3 text-right'f>><'row py-2'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",paging:!0,responsive:!0,pageLength:20,lengthMenu:[[20,50,-1],[20,50,"Semua"]],order:[],columnDefs:[{targets:0,className:"text-center"}],info:!0,language:{sEmptyTable:"Tidak ada data yang tersedia di tabel",sInfo:"Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",sInfoEmpty:"Menampilkan 0 hingga 0 dari 0 entri",sInfoFiltered:"(disaring dari _MAX_ entri keseluruhan)",sInfoPostFix:"",sInfoThousands:".",sLengthMenu:"Tampilkan _MENU_ entri",sLoadingRecords:"Memuat...",sProcessing:"Sedang memproses...",sSearch:"Cari:",sZeroRecords:"Tidak ditemukan data yang cocok",oAria:{sSortAscending:": aktifkan untuk mengurutkan kolom secara menaik",sSortDescending:": aktifkan untuk mengurutkan kolom secara menurun"}},drawCallback:function(){$('[data-bs-toggle="tooltip"]').each(function(){new bootstrap.Tooltip(this)})}})}initForm(){this.setupSoSelect(),this.setupAreaSelect(),this.btnCekOngkir.addEventListener("click",()=>this.checkOngkir())}setupSoSelect(){this.soSelectEl,this.soSelectEl.select2({theme:"bootstrap-5",placeholder:"Pilih Sales Order…",allowClear:!0,ajax:{url:this.soUrl,dataType:"json",delay:250,data:a=>({q:a.term,page:a.page||1}),processResults:(a,n)=>({results:a.results,pagination:{more:a.pagination.more}}),cache:!0},templateResult:({loading:a,no_so:n,tanggal:l,kode_customer:t,nama_toko:s})=>a?"Mencari…":$(`
                        <div>
                        <strong>${n}</strong> – ${l}<br>
                        <small class="text-muted">${t} | ${s}</small>
                        </div>
                    `),templateSelection:a=>a.no_so||a.text}).on("select2:select",async a=>{const n=a.params.data.id;if(!n)return;const l=this.soDetailTpl.replace("__ID__",n);let t;try{t=await fetch(l).then(e=>e.json())}catch(e){console.error("Gagal load detail SO:",e);return}const s=t.customer||{};$("#tanggal_so").text(t.tanggal||"-"),$("#metode_pembayaran").text(t.metode_pembayaran||"-"),$("#kode_customer").text(s.kode_customer||"-"),$("#nama_toko").text(s.nama_toko||"-"),$("#alamat").text(s.alamat||"-"),$("#pemilik").text(s.pemilik||"-"),$("#pasar").text(`(${s.id_pasar||"-"}) ${s.nama_pasar||"-"}`);let i=`
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                            <th>Produk</th><th>Kemasan</th><th>Harga</th>
                            <th>Qty</th><th>Diskon</th><th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;t.details.forEach((e,m)=>{const o=parseFloat(e.harga);i+=`
                        <tr class="product-row"
                        data-product_id="${e.product_id}"
                        data-nama="${e.nama_produk}"
                        data-description="${e.kemasan}"
                        data-value="${o}"
                        data-length="${e.panjang||10}"
                        data-width="${e.lebar||10}"
                        data-height="${e.tinggi||10}"
                        data-weight="${e.berat||1e3}"
                        data-qty="${e.qty}">
                            <input type="hidden" name="detail[${e.product_id}][product_id]" value="${e.product_id}">
                            <td>
                            ${e.kode_produk} - ${e.nama_produk}
                            </td>
                            <td>
                            ${e.kemasan}
                            </td>
                            <td class="text-end">
                            ${r(o)}
                            <input type="hidden" name="detail[${e.product_id}][harga]" value="${o}">
                            </td>
                            <td class="text-end">
                            ${d(e.qty)}
                            <input type="hidden" name="detail[${e.product_id}][qty]" value="${e.qty}">
                            </td>
                            <td class="text-end">
                            ${r(e.diskon)}
                            <input type="hidden" name="detail[${e.product_id}][diskon]" value="${e.diskon}">
                            </td>
                            <td class="text-end">
                            ${r(e.subtotal)}
                            <input type="hidden" name="detail[${e.product_id}][subtotal]" value="${e.subtotal}">
                            </td>
                        </tr>
                        `}),i+=`
                    </tbody>
                    <tfoot>
                        <tr>
                        <td colspan="5" class="text-end fw-semibold">QTY Total</td>
                        <td class="text-end">
                            ${d(t.total_qty)}
                        </td>
                        </tr>
                        <tr>
                        <td colspan="5" class="text-end fw-semibold">Diskon Total</td>
                        <td class="text-end">
                            ${r(t.total_diskon)}
                        </td>
                        </tr>
                        <tr>
                        <td colspan="5" class="text-end fw-bold">Grand Total</td>
                        <td class="text-end fw-bold">
                            ${r(t.grand_total)}
                        </td>
                        </tr>
                    </tfoot>
                    </table>
                </div>
                `,this.detailWrapper.innerHTML=i}).on("select2:clear",()=>{$("#tanggal_so").text("-"),$("#metode_pembayaran").text("-"),$("#kode_customer").text("-"),$("#nama_toko").text("-"),$("#alamat").text("-"),$("#pemilik").text("-"),$("#pasar").text("-"),this.detailWrapper.innerHTML=`
        <div class="text-center text-muted py-3">
          Tidak ada detail yang ditampilkan.
        </div>
      `})}setupAreaSelect(){this.areaSelectEls.select2({theme:"bootstrap-5",placeholder:"Cari wilayah…",allowClear:!0,minimumInputLength:3,ajax:{url:this.areaUrl,dataType:"json",delay:300,data:a=>({q:a.term}),processResults:a=>({results:a.areas.map(n=>({id:n.id,text:n.name}))}),cache:!0}}),this.areaSelectEls.on("select2:select",function(a){const n=$(this).attr("id"),l=a.params.data.text;$(`#${n}_name`).val(l)}),this.areaSelectEls.on("select2:clear",function(){const a=$(this).attr("id");$(`#${a}_name`).val("")})}async checkOngkir(){const a=this.areaSelectEls.filter("#origin").val(),n=this.areaSelectEls.filter("#destination").val(),l=[...document.querySelectorAll(".product-row")].map(t=>({name:t.dataset.nama,description:t.dataset.description,value:+t.dataset.value,length:+t.dataset.length,width:+t.dataset.width,height:+t.dataset.height,weight:+t.dataset.weight,quantity:+t.dataset.qty})).filter(t=>t.quantity>0);if(!a||!n||l.length===0)return showToast(!a||!n?"Silakan pilih asal & tujuan pengiriman dulu.":"Tidak ada item valid untuk menghitung ongkir.","info");$("#harga_ongkir_list").html(`<div class="d-flex justify-content-center py-4">
            <div class="spinner-border" role="status"></div>
            <span class="ms-2">Loading ongkir…</span>
        </div>`);try{const t=await fetch(this.cekOngkirUrl,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},credentials:"same-origin",body:JSON.stringify({origin_area_id:a,destination_area_id:n,couriers:["jne","jnt","sicepat","anteraja"].join(","),items:l})}).then(s=>s.json());if(!t.success||!t.pricing)throw new Error;this.renderOngkirTable(t.pricing)}catch{$("#harga_ongkir_list").html('<div class="text-danger">Gagal mengambil ongkir.</div>')}}renderOngkirTable(a=[]){const n=a.map(l=>`
      <tr>
        <td>${l.courier_name}</td>
        <td>${l.courier_service_name}</td>
        <td>${l.shipment_duration_range} hari</td>
        <td>${r(l.price)}</td>
      </tr>
    `).join("");$("#harga_ongkir_list").html(`
      <div class="table-responsive mt-2">
        <table class="table table-sm table-bordered">
          <thead class="table-light text-center"><tr><th>Kurir</th><th>Layanan</th><th>Estimasi</th><th>Harga</th></tr></thead>
          <tbody>${n}</tbody>
        </table>
      </div>`)}}const h=new c;export{h as default};
