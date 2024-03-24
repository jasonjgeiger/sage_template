@php(the_content())

<hr />

<?php 
 echo carbon_get_post_meta( get_the_ID(), 'page_details' ) 
?>

@if ($pagination)
  <nav class="page-nav" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
