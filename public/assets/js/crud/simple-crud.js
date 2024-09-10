function dbTable() {
  dt_tbl = $("#dt_tbl").DataTable({
    serverSide: true,
    stateSave: false,
    pageLength: 10,
    ajax: {
      url: listuRL,
      data: {},

      beforeSend: function () {},
    },
    columns: [
      {
        name: "index_column",
        data: "index_column",
        orderable: false,

      },
      {
        name: "name",
        data: "name",
      },

      {
        name: "email",
        data: "email",
      },

      {
        name: "action",
        data: "action",
        orderable: false,
      },
    ],
    order: [1, "desc"],
    drawCallback: function (settings, json) {
      $(".dltBtn").on("click",function(){
          const delete_url = $(this).val()
          deleteData(delete_url)
      })
    },
  });
}

function deleteData(uRL){
  $.ajax({
    url: uRL,
    type: 'get',
    success: function(response) {
      console.log(response);
      dt_tbl.ajax.reload();
    }
  })
}

$(document).ready(function(){
  dbTable()
 
})