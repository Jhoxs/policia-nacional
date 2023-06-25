import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space  } from 'antd';
import { Head, Link, useForm } from '@inertiajs/react';
import { useEffect } from 'react';

const { Text, Title } = Typography;


export default function Create({ }) {

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        permisions: []
    });

    useEffect(() => {
        return () => {
        }
    });

    const submit = () => {
        console.log('Formulario');
    };

    console.log(data);
    return (
        <>
            <div className='flex justify-center mt-5'>
                <Title level={3}>
                    Creación de Rol
                </Title>

            </div>
            <Divider></Divider>
            <div className="flex justify-center mt-5'">
                <Form
                    name="basic"
                    layout='vertical'
                    initialValues={data}
                    onFieldsChange={(changedFields) => {
                        changedFields.forEach(item => {
                            setData(item.name[0], item.value);
                        })
                    }}
                    onFinish={submit}
                    autoComplete="off"
                    style={{ width: '31rem' }}

                >
                    <Form.Item
                        label='Nombre del Rol'
                        name='name'
                        validateStatus={errors.name && 'error'}
                        help={errors.name}
                    >
                        <Input size='large'></Input>
                    </Form.Item>
                    <Form.Item name="permisions" label="Permisos Disponibles">
                        <Checkbox.Group className='flex justify-center mt-3'>
                            <Row>
                                <Col span={12}>
                                    <Checkbox value="A" style={{ lineHeight: '32px' }}>
                                        browser.list
                                    </Checkbox>
                                </Col>
                                <Col span={12}>
                                    <Checkbox value="B" style={{ lineHeight: '32px' }}>
                                        B
                                    </Checkbox>
                                </Col>
                                <Col span={12}>
                                    <Checkbox value="C" style={{ lineHeight: '32px' }}>
                                        C
                                    </Checkbox>
                                </Col>
                                <Col span={12}>
                                    <Checkbox value="D" style={{ lineHeight: '32px' }}>
                                        D
                                    </Checkbox>
                                </Col>
                                <Col span={12}>
                                    <Checkbox value="E" style={{ lineHeight: '32px' }}>
                                        E
                                    </Checkbox>
                                </Col>
                                <Col span={12}>
                                    <Checkbox value="F" style={{ lineHeight: '32px' }}>
                                        F
                                    </Checkbox>
                                </Col>
                            </Row>
                        </Checkbox.Group>
                    </Form.Item>
                    <Space size={16} className='flex justify-center mb-3'>
                        <Button 
                            type="primary" 
                            htmlType="submit" 
                            loading={processing}
                            size="large" 
                            className="mt-5 bg-[#203956]"
                        >
                            Guardar Rol
                        </Button>
                    </Space>
                </Form>
            </div>

        </>

    );
}