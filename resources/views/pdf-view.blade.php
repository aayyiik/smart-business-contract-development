@extends('layouts.master-dashboard')
@section('page-title', 'Dashboard')
@section('active-dashboard','active')
@section('address')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
@endsection
@section('dashboard')
<div class="row">
   
<h1>PDF with QR Code and Table</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['address'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
</div>
@endsection
