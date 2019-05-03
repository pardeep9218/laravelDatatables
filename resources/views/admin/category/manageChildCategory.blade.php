@foreach($children as $cat)

    <?php $dashes .= '-'; $selected=(!empty($selectedcat) && $cat->id==$selectedcat)? 'selected' :''; ?>
    <option value="{{ $cat->id }}" {{ $selected }}>{{ $dashes }} {{ $cat->name }}</option><br />
    @if(count($cat->children))
        @include('admin.category.manageChildCategory',['children' => $cat->children,'dashes'=>$dashes,'selectedcat'=>$selectedcat])
    @endif
@endforeach
  