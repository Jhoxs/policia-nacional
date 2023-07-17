import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { DatePicker, Input, InputNumber, Select, Button, Form, Row, Col, Cascader } from 'antd';
import { PlusOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';


export default function RegisterSuggestion({typeSugg, circuitList }) {

    const initialUrl = window.location.origin;
    
    const {data:circList} = circuitList;

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        lastname: '',
        description: '',
        type_suggestion: [],
        dependence: [],
    });

    const filter = (inputValue, path) => 
        path.some((option) => option.label.toLowerCase().indexOf(inputValue.toLowerCase()) > -1);
    

    const submit = (e) => {
        post(route('suggestion.storeform'), {
            onSuccess: () => {
            }
        });
    };

    return (
        <GuestLayout>
            <Head title="Register Suggestion" />

            <div className="mt-5"></div>

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
                scrollToFirstError
                style={{ width: '100%' }}

            >

                <Form.Item
                    label='Circuito / Subcircuito*'
                    name='dependence'
                    validateStatus={errors.dependence && 'error'}
                    help={errors.dependence}
                    className='mb-4'
                >
                    <Cascader 
                        size='large' 
                        options={circList}
                        placeholder='Selecciona un Subcircuito'
                        showSearch={{ filter }}
                    />
                </Form.Item>

                <Form.Item
                    label='Tipo de solicitud*'
                    name='type_suggestion'
                    validateStatus={errors.type_suggestion && 'error'}
                    help={errors.type_suggestion}
                    className='mb-4'
                >
                    <Select size='large' options={typeSugg}></Select>
                </Form.Item>

                <Form.Item
                    label='Nombres*'
                    name='name'
                    validateStatus={errors.name && 'error'}
                    help={errors.name}
                    className='mb-4'
                >
                    <Input size='large'></Input>
                </Form.Item>

                <Form.Item
                    label='Apellidos*'
                    name='lastname'
                    validateStatus={errors.lastname && 'error'}
                    help={errors.lastname}
                    className='mb-4'
                >
                    <Input size='large'></Input>
                </Form.Item>
                
                <Form.Item
                    label='Detalle*'
                    name='description'
                    validateStatus={errors.description && 'error'}
                    help={errors.description}
                    className='mb-4'
                >
                    <Input.TextArea size='large'></Input.TextArea>
                </Form.Item>



                <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                    <Col>
                        <Link href={initialUrl}>
                            <Button
                                size="large"
                                className="mt-5 shadow-md"
                            >
                                Volver
                            </Button>
                        </Link>
                    </Col>
                    <Col>
                        <Button
                            type="primary"
                            htmlType="submit"
                            loading={processing}
                            size="large"
                            className="mt-5 bg-[#203956]"
                        >
                            Registrar
                        </Button>
                    </Col>
                </Row>


            </Form>

        </GuestLayout>
    );
}
