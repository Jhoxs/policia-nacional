import { Link, Head } from '@inertiajs/react';
import { Button, Col, Row, Typography } from 'antd';

export default function Welcome({auth}) {
    return (
        <>
            <Head title="Welcome" />
            <div className='d-flex justify-center align-center h-100vh'>
                <Row justify="center">
                    <Col className='text-center'>
                        <Typography.Title level={2}>Bienvenidos a la Flota de Gestión Vehicular</Typography.Title>
                        {auth.user ?
                        
                        <Link href={route('dashboard.index')}>
                            <Button 
                                type="primary" 
                                size="large" 
                                className="ml-4 mt-2 bg-[#203956]"
                            >
                            Ingresar
                            </Button>
                        </Link>
                        :<Link href={route('login')}>
                            <Button 
                                type="primary" 
                                size="large" 
                                className="ml-4 mt-2 bg-[#203956]"
                            >
                            Iniciar Sesión
                            </Button>
                        </Link>
                        }
                    </Col>
                </Row>
            </div>
        </>
    );
}
