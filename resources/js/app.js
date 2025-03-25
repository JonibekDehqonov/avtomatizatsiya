import $ from 'jquery'; // jQuery import qilish
import 'datatables.net'; // DataTables import qilish


$(document).ready(function() {
  $('#products-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/products-data', 
    columns: [
      { data: 'id',  },
      { data: 'name',  },
      { data: 'price',  },
      { data: 'stock',  },
      { data: 'created_at',  },
      { data: 'updated_at', },
    ],
  });
});
