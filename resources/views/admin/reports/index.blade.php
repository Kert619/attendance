@extends('admin.layouts.layout')
@section('title','Reports')
@section('content')
<div class="table-responsive h-100">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="row m-0 gx-0 align-items-center sticky-left">
        <div class="col-auto">
            <input type="hidden" class="form-control shadow-none rounded-0" name="entries"
                value="{{ request('entries', 5) }}" autocomplete="off">

            <div class="d-flex flex-column flex-md-row gap-2">
                <div class="d-flex align-items-center gap-2 me-3">
                    <input type="date" class="form-control shadow-none rounded-0" name="date_from"
                        value="{{ $dateFrom }}" onchange="this.form.submit()">
                </div>
                <div class="d-flex align-items-center gap-2 me-3">
                    <input type="date" class="form-control shadow-none rounded-0" name="date_to" value="{{ $dateTo }}"
                        onchange="this.form.submit()">
                </div>
            </div>
        </div>

        <div class="col-lg-6 mt-2 mt-lg-0">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control shadow-none rounded-0" placeholder="Search any student or course"
                    name="search" autocomplete="off" autofocus value="{{ request('search') }}">
                <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    <span>Search</span>
                </button>
            </div>
        </div>

    </form>

    <form action="{{ route('admin.reports.download') }}" method="GET" class="mx-0 my-2 sticky-left">
        <input type="hidden" name="date_from" value="{{ request('date_from') }}">
        <input type="hidden" name="date_to" value="{{ request('date_to') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">Generate PDF</button>
    </form>

    <table class="table align-middle" style="font-size: 14px">
        <thead class="sticky-top">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Fullname</th>
                <th scope="col">Course</th>
                <th scope="col">Time-in AM</th>
                <th scope="col">Time-out AM</th>
                <th scope="col">Time-in PM</th>
                <th scope="col">Time-out PM</th>
                <th scope="col">Status AM</th>
                <th scope="col">Status PM</th>
            </tr>
        </thead>
        <tbody>
            @if(count($attendance) == 0)
            <tr>
                <td colspan="9" class="text-center">No results found</td>
            </tr>
            @endif
            @php
            $counter = 1;
            @endphp

            @foreach($attendance as $row)
            <tr class="row-item" onclick="makeActive(this)">
                <td>{{$counter++}}</td>
                <td class="text-nowrap">{{ date('F d, Y', strtotime($row->date)); }}</td>
                <td>{{$row->student->fullname}}</td>
                <td>{{ $row->student->course->course }}</td>
                <td>{{ $row->time_in_am ? date('h:i A', strtotime($row->time_in_am)) : '' }}</td>
                <td>{{ $row->time_out_am ? date('h:i A', strtotime($row->time_out_am)) : '' }}</td>
                <td>{{ $row->time_in_pm ? date('h:i A', strtotime($row->time_in_pm)) : '' }}</td>
                <td>{{ $row->time_out_pm ? date('h:i A', strtotime($row->time_out_pm)) : '' }}</td>
                <td
                    class="fw-bold {{ strtolower($row->status_am) == 'absent' ? 'text-danger' : (strtolower($row->status_am) == 'on-time' ? 'text-success' : 'text-primary')  }}">
                    {{$row->status_am}}
                </td>
                <td
                    class="fw-bold {{ strtolower($row->status_pm) == 'absent' ? 'text-danger' : (strtolower($row->status_pm) == 'on-time' ? 'text-success' : 'text-primary')  }}">
                    {{$row->status_pm}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row m-0 gy-2 gy-md-0 justify-content-between">
        <div class="col-auto">
            <div class="d-flex align-items-center gap-2">
                <span>Show</span>
                <form action="{{ route('admin.reports.index') }}">
                    <select name="entries" class="form-select form-select-sm shadow-none rounded-0"
                        onchange="this.form.submit()">
                        <option value="5" {{ $attendance->perPage() == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $attendance->perPage() == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $attendance->perPage() == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $attendance->perPage() == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    <input type="hidden" class="form-control shadow-none rounded-0" name="search"
                        value="{{ request('search', '') }}" autocomplete="off">
                    <input type="hidden" class="form-control shadow-none rounded-0" name="date_from"
                        value="{{ request('date_from', date('Y-m-d')) }}" autocomplete="off">
                    <input type="hidden" class="form-control shadow-none rounded-0" name="date_to"
                        value="{{ request('date_to', date('Y-m-d')) }}" autocomplete="off">
                </form>
                <span>Entries</span>
            </div>
        </div>
        <div class="col-auto">
            <ul class="pagination">
                @php
                $search = request('search', '');
                $entries = request('entries', 5);
                $dateFrom = request('date_from', date('Y-m-d'));
                $dateTo = request('date_to', date('Y-m-d'));
                $currentPage = $attendance->currentPage();
                $lastPage = $attendance->lastPage();
                @endphp
                @if ($currentPage == 1)
                <li class="page-item disabled"><span class="page-link rounded-0">Previous</span></li>
                @else
                <li class="page-item"><a class="page-link shadow-none rounded-0"
                        href="{{ $attendance->previousPageUrl() }}&entries={{ $entries }}&search={{ $search }}&date_from={{ $dateFrom }}&date_to={{ $dateTo }}"
                        rel="prev">Previous</a></li>
                @endif

                <li class="page-item"><span class="page-link rounded-0 text-nowrap active">{{ $currentPage }}
                        of
                        {{ $lastPage }}</span></li>

                @if ($currentPage == $lastPage)
                <li class=" page-item disabled"><span class="page-link rounded-0">Next</span></li>
                @else
                <li class="page-item"><a class="page-link shadow-none rounded-0"
                        href="{{ $attendance->nextPageUrl() }}&entries={{ $entries }}&search={{ $search }}&date_from={{ $dateFrom }}&date_to={{ $dateTo }}"
                        rel="next">Next</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<script>
const searchInput = document.querySelector("input[name='search']");
searchInput.selectionStart = searchInput.selectionEnd = searchInput.value.length;
</script>
@endsection