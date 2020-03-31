<?php

namespace LeoPersan;

use Exception;

class Codec
{
    private $data = [];

    private $map = [
        'a' => false,
        'b' => false,
        'c' => false,
        'd' => false,
        'e' => false,
        'f' => false,
        'g' => false,
        'h' => false,
        'i' => false,
        'j' => false,
        'k' => false,
        'l' => false,
        'm' => false,
        'n' => false,
        'o' => false,
        'p' => false,
        'q' => false,
        'r' => false,
        's' => false,
        't' => false,
        'u' => false,
        'v' => false,
        'w' => false,
        'x' => false,
        'y' => false,
        'z' => false
    ];

    public function __construct($data)
    {
        if (is_string($data)) {
            $this->data = json_decode($data);
        } elseif (is_array($data)) {
            $this->data = (object) $data;
        } else {
            throw new Exception("Dados inválidos", 1);
        }
        $this->run();
    }

    protected function run()
    {
        $this->setMap();
        if (empty($this->data->decifrado))
            return $this->runDecode();
        if (empty($this->data->cifrado))
            return $this->runCodify();
    }

    protected function setMap()
    {
        if (!is_int($this->data->numero_casas))
            throw new Exception("Dados inválidos", 1);
            $this->data->numero_casas = 2;
        $original_map = array_keys($this->map);
        foreach ($this->map as $letter => &$value) {
            $pos_original = array_search($letter,$original_map);
            $new_pos = $pos_original+$this->data->numero_casas;
            if ($new_pos >= count($original_map)) $new_pos -= count($original_map);
            $value = $original_map[$new_pos];
        }
    }

    protected function runDecode()
    {
        $map = array_flip($this->map);
        foreach (str_split($this->data->cifrado) as $letter) {
            $this->data->decifrado .= $map[$letter] ?? $letter;
        }
        $this->data->resumo_criptografico = sha1($this->data->decifrado);
    }

    protected function runCodify()
    {
        foreach (str_split($this->data->decifrado) as $letter) {
            $this->data->cifrado .= $this->map[$letter] ?? $letter;
        }
    }

    public function getObject()
    {
        return $this->data;
    }

    public function getArray()
    {
        return (array) $this->data;
    }

    public function getJson()
    {
        return json_encode($this->data);
    }
}