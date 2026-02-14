@props([
    'object' => null
])

@if ($object)
<pre class="small bg-light p-2 rounded border" style="color: rgb(137, 33, 197)">
    {{ 
        $object->toJson(JSON_PRETTY_PRINT) 
    }}
</pre>
@endif
