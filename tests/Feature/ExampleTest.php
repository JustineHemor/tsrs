<?php

it('returns an unsuccessful response', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});
