@extends('templates.angular')

@section('body')

<div style="background:#FFF; padding: 30px;">
    <h3 style="margin:0px; border-left:4px solid #EE3D26; padding-left:20px;">{{ $title }}</h3><br/>
    <p style="line-height:12px; margin-top:20px;">
        {{ $body }}
    </p>
</div>

@stop