
<tr>
    <td  class="text-center sticky"  style="right: 0px;">
        {{ $index + 1 }}
    </td>
    <td  class="sticky" style="right: 36.5px;">
        {{-- <x-form.input type="date" name="date_executive" required :value="$executive->date_executive" wire:input="update('date_executive', $event.target.value)" /> --}}
        <x-form.input type="date" name="implementation_date" required wire:model="implementation_date" wire:input="update('implementation_date', $event.target.value)"  />
    </td>
    {{-- <td>
        <x-form.input type="number" name="budget_number" :value="$executive->budget_number" placeholder="رقم الموزانة : 1212" class="text-center" required wire:input="budget_number_check($event.target.value)" />
        <div id="budget_number_error" class="text-danger"  >
            @if ($budget_number_error != '')
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span title="يمكنك جعل الرقم لتخصيص آخر هذا فقط تحذير" style="white-space: pre-wrap;">{{ $budget_number_error  }}</span>
            @endif
        </div>
    </td> --}}
    <td class="sticky" style="right: 161px">
        <x-form.input name="broker_name" class="name" list="brokers_list" :value="$executive->broker_name" required wire:input="update('broker_name', $event.target.value)" />
        <datalist id="brokers_list">
            @foreach ($brokers as $broker)
                <option value="{{ $broker }}">
            @endforeach
        </datalist>
    </td>
    <td  class="sticky" style="right: 360px;">
        <x-form.input name="account" class="name" list="account_list" :value="$executive->account" required wire:input="update('account', $event.target.value)" />
        <datalist id="account_list">
            @foreach ($accounts as $account)
                <option value="{{ $account }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="affiliate_name" class="name" list="affiliate_name_list" :value="$executive->affiliate_name" required wire:input="update('affiliate_name', $event.target.value)" />
        <datalist id="affiliate_name_list">
            @foreach ($affiliate_names as $affiliate_name)
                <option value="{{ $affiliate_name }}">
            @endforeach
       </datalist>
    </td>
    <td>
        <x-form.input name="project_name" list="projects_list" :value="$executive->project_name" required wire:input="update('project_name', $event.target.value)" />
        <datalist id="projects_list">
            @foreach ($projects as $project)
                <option value="{{ $project }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="detail" list="detail_list" :value="$executive->detail" required wire:input="update('detail', $event.target.value)" />
        <datalist id="detail_list">
            @foreach ($details as $detail)
                <option value="{{ $detail }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.input name="item_name" list="items_list" :value="$executive->item_name" required wire:input="update('item_name', $event.target.value)" />
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
        <x-form.input type="number" class="number" min="0" step="0.01" name="price"  wire:model="price" wire:input="total"/>
    </td>
    <td>
        <x-form.input type="number" style="width: 75px !important;"  step="0.01" name="total_ils" wire:model="total_ils" wire:input="update('total_ils', $event.target.value)"/>
    </td>
    <td>
        <x-form.input name="received" style="width: 76px !important;"  list="received_list" :value="$executive->received" wire:input="update('received', $event.target.value)" />
        <datalist id="received_list">
            @foreach ($receiveds as $received)
                <option value="{{ $received }}">
            @endforeach
        </datalist>
    </td>
    <td>
        <x-form.textarea name="notes" :value="$executive->notes" rows="2" wire:input="update('notes', $event.target.value)" />
    </td>
    <td>
        <x-form.input type="number" step="0.01"  style="width: 76px !important;" name="amount_payments"  :value="$executive->amount_payments" wire:input="update('amount_payments', $event.target.value)"/>
    </td>
    <td>
        <x-form.textarea name="payment_mechanism" :value="$executive->payment_mechanism" rows="2" wire:input="update('payment_mechanism', $event.target.value)" />
    </td>
    <td>{{ $executive->user_name }}</td>
    <td>{{ $executive->manager_name }}</td>
    <td class="align-middle">
        <div class="d-flex align-items-center">
            @can('update','App\\Models\Allocation')
            <a href="{{route('executives.edit', $executive->id)}}" class="text-secondary font-weight-bold text-xs"data-toggle="tooltip" >
                تعديل
            </a>
            @endcan
            @can('delete','App\\Models\Allocation')
            <form action="{{route('executives.destroy', $executive->id)}}" method="post">
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
