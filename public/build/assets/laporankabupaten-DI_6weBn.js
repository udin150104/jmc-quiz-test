function h(){function p(i,c=5){const n=i.current_page,l=i.last_page;let a="";const o=(t,e=null,s=!1,r=!1)=>`
      <li class="page-item ${s?"active":""} ${r?"disabled":""} rounded-0">
        <a class="page-link  rounded-0" href="#" data-page="${r?"":t}">
          ${e??t}
        </a>
      </li>`;if(a+=o(n-1,'<i class="bi bi-caret-left"></i>',!1,n===1),l<=c+2)for(let t=1;t<=l;t++)a+=o(t,null,t===n);else{a+=o(1,null,n===1);let t=Math.max(2,n-Math.floor(c/2)),e=Math.min(l-1,n+Math.floor(c/2));t>2&&(a+='<li class="page-item disabled"><span class="page-link">…</span></li>');for(let s=t;s<=e;s++)a+=o(s,null,s===n);e<l-1&&(a+='<li class="page-item disabled"><span class="page-link">…</span></li>'),a+=o(l,null,n===l)}a+=o(n+1,'<i class="bi bi-caret-right"></i>',!1,n===l),$("#pagination").html(a)}$(document).on("click","#pagination .page-link",function(i){i.preventDefault();const c=parseInt($(this).data("page"));isNaN(c)||d(c)});function d(i=1){const c=$("#search").val(),n=$("#filter-provinsi").val();$.get("/application/laporan/kabupaten/api/data",{page:i,search:c,provinsi:n},function(l){let a="";const o=new Date,t=[];l.data.length>0?l.data.forEach(e=>{const s=e.created_at?e.created_at.replace(" ","T"):null;let r=!1;if(s){const u=new Date(s);r=o-u<=60*800}const f=`row-${e.id}`;r&&t.push(f),a+=`
          <tr id="${f}" >
            <td>${e.nama}</td>
            <td>${e.nama_provinsi}</td>
            <td class="text-end">
              ${e.penduduk_count} <small>Penduduk</small>
            </td>
          </tr>`}):a+='<tr><td colspan="3" class="text-muted">Belum Ada Data</td></tr>',$("#table-list tbody").html(a),p(l),t.forEach(e=>{setTimeout(()=>{$(`#${e}`).removeClass("table-info")},1e5)})})}d(1),$("#search").on("keyup",function(i){i.key==="Enter"&&d(1)}),$("#filter-provinsi").on("change",function(i){d(1)})}export{h as init};
