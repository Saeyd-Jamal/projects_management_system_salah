<tr>
    <td  class="text-center">
        {{ $index + 1 }}
    </td>
    <td class="sticky" style="right: 0px;">
        <x-form.input type="date" name="date_allocation" required :value="$allocation->date_allocation" wire:input="update('date_allocation', $event.target.value)" />
    </td>
    <td class="sticky" style="right: 145px;">
        <x-form.input type="number" name="budget_number" :value="$allocation->budget_number" placeholder="رقم الموزانة : 1212" class="number" required wire:input="budget_number_check($event.target.value)" />
        <div id="budget_number_error" class="text-danger"  >
            @if ($budget_number_error != '')
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span title="يمكنك جعل الرقم لتخصيص آخر هذا فقط تحذير" style="white-space: pre-wrap;">{{ $budget_number_error  }}</span>
            @endif
        </div>
    </td>
    <td class="sticky" style="right: 235px;">
        <x-form.input name="broker_name" class="name" list="brokers_list" :value="$allocation->broker_name" required  wire:input="update('broker_name', $event.target.value)"/>
        <datalist id="brokers_list">
            @foreach ($brokers as $broker)
                <option value="{{ $broker }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="organization_name" class="name" list="organizations_list" :value="$allocation->organization_name" required  wire:input="update('organization_name', $event.target.value)"/>
        <datalist id="organizations_list">
            @foreach ($organizations as $organization)
                <option value="{{ $organization }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="project_name" list="projects_list" :value="$allocation->project_name" required wire:input="update('project_name', $event.target.value)" />
        <datalist id="projects_list">
            @foreach ($projects as $project)
                <option value="{{ $project }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="item_name" style="width: 122px !important;" list="items_list" :value="$allocation->item_name" required wire:input="update('item_name', $event.target.value)" />
        <datalist id="items_list">
            @foreach ($items as $item)
                <option value="{{ $item }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input type="number" class="number" min="0" name="quantity" wire:model="quantity" wire:input="total"/>
    </td>
    <td>
        <x-form.input type="number" class="number" min="0" step="0.01" name="price"  wire:model="price" wire:input="total" :value="$allocation->price" />
    </td>
    <td>
        <x-form.input type="number" class="number" min="0" step="0.01" name="total_dollar" wire:model="total_dollar" readonly/>
    </td>
    <td>
        <x-form.input  type="number" style="width: 100px !important;" step="0.01" name="allocation" wire:model="allocation_field" wire:input="allocationFun" required />
    </td>
    <td>
        <select class="form-control text-center" name="currency_allocation" id="currency_allocation" wire:model="currency_allocation" wire:input="allocationFun" style="width: 100px !important;">
            <option label="فتح القائمة">
            @foreach ($currencies as $currency)
                <option value="{{ $currency->code }}" @selected($currency->code == $allocation->currency_allocation || $currency->code == "USD")>{{ $currency->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <x-form.input type="number" style="width: 100px !important;" step="0.01" name="amount" wire:model="amount" readonly/>
    </td>
    <td>
        <x-form.input type="number" min="0" style="width: 100px !important;" name="number_beneficiaries" :value="$allocation->number_beneficiaries" wire:input="update('number_beneficiaries', $event.target.value)"/>
    </td>
    <td>
        <x-form.textarea name="implementation_items" :value="$allocation->implementation_items" rows="1"  wire:input="update('implementation_items', $event.target.value)"/>
    </td>
    <td>
        <x-form.input type="date" name="date_implementation" :value="$allocation->date_implementation" wire:input="update('date_implementation', $event.target.value)" />
    </td>
    <td>
        <x-form.textarea name="implementation_statement" :value="$allocation->implementation_statement"  rows="1" wire:input="update('implementation_statement', $event.target.value)" />
    </td>
    <td>
        <x-form.input type="number" step="0.01" style="width: 100px !important;" name="amount_received" :value="$allocation->amount_received" wire:input="update('amount_received', $event.target.value)" />
    </td>
    <td>
        <select class="form-control text-center" style="width: 100px !important;" name="currency_received" id="currency_received" wire:model="currency_received" wire:input="update('currency_received', $event.target.value)">
            <option label="فتح القائمة">
            @foreach ($currencies as $currency)
                <option value="{{ $currency->code }}" @selected($currency->code == $allocation->currency_received || $currency->code == "USD")>{{ $currency->name }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <x-form.textarea name="notes" :value="$allocation->notes" rows="1"  wire:input="update('notes', $event.target.value)" />
    </td>
    <td>{{ $allocation->user_name }}</td>
    <td>{{ $allocation->manager_name }}</td>
    <td class="align-middle">
        <div class="d-flex align-items-center">
            @can('update','App\\Models\Allocation')
            <a href="{{route('allocations.edit', $allocation->id)}}" class="text-secondary font-weight-bold text-xs"data-toggle="tooltip" >
                تعديل
            </a>
            @endcan
            @can('delete','App\\Models\Allocation')
            <form action="{{route('allocations.destroy', $allocation->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0" data-toggle="tooltip" data-original-title="Delete user">
                    حذف
                </button>
            </form>
            @endcan
        </div>
    </td>
</tr>
