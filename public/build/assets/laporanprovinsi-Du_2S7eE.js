function g(){function f(s,c=5){const t=s.current_page,e=s.last_page;let l="";const n=(a,o=null,i=!1,r=!1)=>`
      <li class="page-item ${i?"active":""} ${r?"disabled":""} rounded-0">
        <a class="page-link  rounded-0" href="#" data-page="${r?"":a}">
          ${o??a}
        </a>
      </li>`;if(l+=n(t-1,'<i class="bi bi-caret-left"></i>',!1,t===1),e<=c+2)for(let a=1;a<=e;a++)l+=n(a,null,a===t);else{l+=n(1,null,t===1);let a=Math.max(2,t-Math.floor(c/2)),o=Math.min(e-1,t+Math.floor(c/2));a>2&&(l+='<li class="page-item disabled"><span class="page-link">…</span></li>');for(let i=a;i<=o;i++)l+=n(i,null,i===t);o<e-1&&(l+='<li class="page-item disabled"><span class="page-link">…</span></li>'),l+=n(e,null,t===e)}l+=n(t+1,'<i class="bi bi-caret-right"></i>',!1,t===e),$("#pagination").html(l)}$(document).on("click","#pagination .page-link",function(s){s.preventDefault();const c=parseInt($(this).data("page"));isNaN(c)||d(c)});function d(s=1){const c=$("#search").val();$.get("/application/laporan/provinsi/api/data",{page:s,search:c},function(t){let e="";const l=new Date,n=[];t.data.length>0?t.data.forEach(a=>{const o=a.created_at?a.created_at.replace(" ","T"):null;let i=!1;if(o){const u=new Date(o);i=l-u<=60*800}const r=`row-${a.id}`;i&&n.push(r),e+=`
          <tr id="${r}" >
            <td>${a.nama}</td>
            <td class="text-end">
              ${a.penduduk_count} <small>Penduduk</small>
            </td>
          </tr>`}):e+='<tr><td colspan="2" class="text-muted">Belum Ada Data</td></tr>',$("#table-list tbody").html(e),f(t),n.forEach(a=>{setTimeout(()=>{$(`#${a}`).removeClass("table-info")},1e5)})})}d(1),$("#search").on("keyup",function(s){s.key==="Enter"&&d(1)})}export{g as init};
