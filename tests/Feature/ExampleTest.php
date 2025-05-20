<?php

it('returns a successful response', function () {
    $response = $this->get('/data_siswa');

    $response->assertStatus(200);
});
