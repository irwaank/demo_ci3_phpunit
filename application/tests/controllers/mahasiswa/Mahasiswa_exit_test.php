<?php

class Mahasiswa_exit_test extends TestCase {
    /**
     * @test
     * @testdox because the controller end with exit, this controller never counted as tested in coverage
     * @codeCoverageIgnore
     */
    public function it_should_return_200() {
        try {
            $this->request('GET', 'mahasiswa/exit_controller');
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }
        $this->assertResponseCode(200);
    }    
}