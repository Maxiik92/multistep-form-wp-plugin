<?php

$inputs = [
  'name' => [
    'name' => 'Name',
    'html' => '<div class="input-group flex-nowrap">
                <input type="text" class="form-control" id="name" name="name">
                <i style="color:#179A09;" class="fa-regular fa-user"></i>
              </div>'
  ],
  'email' => [
    'name' => 'Email',
    'html' => '<div class="input-group flex-nowrap">
                <input type="email" class="form-control" id="email" name="email">
                <i style="color:#A4070A;" class="fa-regular fa-envelope"></i>
              </div>'
  ],
  'country' => [
    'name' => 'Country',
    'html' => '<input id="country" class="form-control" type="text" name="country"/>'
  ],
  'phone_number' => [
    'name' => 'Phone number',
    'html' => '<div class="input-group flex-nowrap">
                <input type="tel" class="form-control" id="phone_number" name="phone_number">
                <i style="color:#4a3aff;" class="fa-solid fa-phone"></i>
              </div>'
  ],
  'company' => [
    'name' => 'Company',
    'html' => '<div class="input-group flex-nowrap">
                <input type="text" class="form-control" id="company" name="company">
                <i style="color:#8e6e53;" class="fa-regular fa-building"></i>
              </div>'
  ],
  'address' => [
    'name' => 'Address',
    'html' => '<div class="input-group flex-nowrap">
                <input type="text" class="form-control" id="address" name="address">
                <i style="color:#EE4B6A;" class="fa-solid fa-location-crosshairs"></i>
              </div>'
  ],
  'postal_code' => [
    'name' => 'Postal code',
    'html' => '<div class="input-group flex-nowrap">
                <input type="text" class="form-control" id="postal_code" name="postal_code">
                <i style="color:#FFA400" class="fa-solid fa-envelopes-bulk"></i>
              </div>'
  ],
  'age' => [
    'name' => 'Age',
    'html' => '<div class="input-group flex-nowrap">
                <input type="number" class="form-control" id="age" name="age">
                <i style="color:#E2BCA1" class="fa-solid fa-baby"></i>
              </div>'
  ],
  'music_genre' => [
    'name' => 'Favourite music Genre',
    'html' => '<div class="input-group flex-nowrap">
                  <select id="music_genre" name="music_genre" class="form-select form-control selectpicker">
                    <option selected>Pick a genre</option>
                    <option value="metal">Metal</option>
                    <option value="blues">Blues</option>
                    <option value="pop">Pop</option>
                    <option value="electronic">Electronic</option>
                    <option value="hip-hop">Hip-hop</option>
                    <option value="disco">Disco</option>
                    <option value="country">Country</option>
                  </select>
                  <i style="color:#2A2A72; padding-right:15px;" class="fa-solid fa-music"></i>
                </div>'
  ],

  'form_rank' => [
    'name' => 'Rank this form (1 worst 5 best)',
    'html' => '<div class="range-wrap">
                <div class="range-value" id="rangeV"></div>
                <input id="form_rank" name="form_rank" step="1" type="range" class="form-range" min="1" max="5"/>
              </div>'
  ]
];