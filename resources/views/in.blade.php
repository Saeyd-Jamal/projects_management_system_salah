<x-front-layout>
    <x-slot:breadcrumb>
        <li><a href="#">الرئيسية</a></li>
    </x-slot:breadcrumb>
    @push('styles')
        <!-- Handsontable CSS -->
        <link href="{{asset('css/tabulator.min.css')}}" rel="stylesheet">
    @endpush
    <div class="container mt-5">
        <h1 class="text-center">Excel-like Table</h1>
        <div class="table-responsive">
            <table id="example-table">
                <thead>
                    <tr>
                        <th>اسم العمود 1</th>
                        <th>اسم العمود 2</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- سيتم إدخال البيانات هنا بواسطة Laravel -->
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->super_admin }}</td>
                        <td>
                            <button class="edit-btn" data-id="{{ $item->id }}">تعديل</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <datalist id="datalist1">
                <option value="خيار 1">
                <option value="خيار 2">
            </datalist>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('js/tabulator.min.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var table = new Tabulator("#example-table", {
                layout: "fitColumns",
                columns: [
                    {
                        title: "اسم العمود 1",
                        field: "name",
                        formatter: function(cell) {
                            // تنسيق لإدخال نص
                            return `<input type="text" value="${cell.getValue()}" list="datalist1" class="input-field">`;
                        },
                        cellEdited: function(cell) {
                            // هنا يمكنك الحصول على القيمة الجديدة بعد تعديل الخلية
                            console.log("New Value:", cell.getValue());
                        }
                    },
                    {
                        title: "اسم العمود 2",
                        field: "super_admin",
                        formatter: function(cell) {
                            // تنسيق لإدخال اختيار
                            return `<select class="select-field">
                                <option value="خيار 1" ${cell.getValue() === 'خيار 1' ? 'selected' : ''}>خيار 1</option>
                                <option value="خيار 2" ${cell.getValue() === 'خيار 2' ? 'selected' : ''}>خيار 2</option>
                            </select>`;
                        },
                        cellEdited: function(cell) {
                            // هنا يمكنك الحصول على القيمة الجديدة بعد تعديل الخلية
                            console.log("New Value:", cell.getValue());
                        }
                    },
                    {
                        title: "الإجراء",
                        field: "action",
                        formatter: function(cell) {
                            return `<button class="edit-btn" data-id="${cell.getRow().getData().id}">تعديل</button>`;
                        },
                    },
                ],
            });
        });
    </script>
    @endpush
</x-front-layout>
