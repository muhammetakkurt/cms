@extends('layouts.admin')
@section('title')
	{{$user->fullName().' Detayı'}}
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
	<legend>{{$user->fullName()}} Aktiviteleri</legend>
		<table class="table">
			<thead>
				<tr>
					<th>Mesaj</th>
					<th width="90">İp</th>
					<th width="150">Log Tarihi</th>
				</tr>
			</thead>
			<tbody>
				@if(count($activities)>0)
				@foreach($activities as $activity)
					<tr>
						<td>{{$activity->message()}}</td>
						<td>{{$activity->ip}}</td>
						<td>{{$activity->created_at}}</td>
					</tr>
				@endforeach
				@else
					<tr>
						<td colspan="3">Herhangi bir kayıt bulunmamakta</td>
					</tr>
				@endif
			</tbody>
		</table>
		<div class="row text-center">
			{{$activities->links()}}	
		</div>
	</div>
</div>
@stop