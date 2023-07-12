import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, Cascader, Select, Table } from 'antd';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';

const { Text, Title } = Typography;


const Create = ({ provinces, modelInfo }) => {

    const { data, setData, post, processing, errors } = useForm({
        dependence: [],
        modelSelected: []

    });
    
    const column = [
        {
            title: 'Placa',
            dataIndex: 'plate',
            width:'35%',
            align:'center'
        },
        {
            title: 'Chasis',
            dataIndex: 'chassis',
            width:'65%',
            align:'center'
        },
    ];
    const proviceData = provinces?.data;
    const { permissions } = usePage().props?.auth || [];
    
    //SECCION TABLA
    const { data: dataSource, meta } = modelInfo;
    const [selectedRowKeys, setSelectedRowKeys] = useState([]);
    const [loading, setLoading] = useState(false);

    const onSelectOne = (record, selected, selectedRows) => {
        setLoading(true);
        const { key } = record;

        if(selected){
            //Guarda la informacion de los array
            const prevInfo = selectedRowKeys;
            prevInfo.push(key);
            //Evita los datos duplicados
            const uniqueSelectedRowKeys = Array.from(new Set(prevInfo)).filter(Boolean);
            setSelectedRowKeys(uniqueSelectedRowKeys);
            setData('modelSelected',uniqueSelectedRowKeys);
            setLoading(false);
        }else{
            const prevFilter = selectedRowKeys;
            const shiftedArray = prevFilter.filter((element) => element !== key);
            setSelectedRowKeys(shiftedArray);
            setLoading(false);
            setData('modelSelected',shiftedArray);
        }
    };
    const rowSelection = {
        selectedRowKeys,
        onSelect: onSelectOne,
        hideSelectAll:true
    };

    const links = meta?.links;

    const state = {
        dataSource: dataSource,
        pagination: {
            total: meta.total,
            pageSize: meta.per_page,
            current: meta.current_page,
            showTotal: (total, range) => `${range[0]}-${range[1]} de ${total} Datos`
        },
        filters: {},
        loading: false
    }

    const { pagination } = state;

    const handleTableChange = (pagination, filters) => {
        const { url } = { ...links.find((link) => link.label == pagination.current) };

        //Send data from url 
        router.visit(url, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    };
    //FIN SECCION TABLA

    const filter = (inputValue, path) =>
        path.some((option) => option.label.toLowerCase().indexOf(inputValue.toLowerCase()) > -1);

    

    const submit = (e) => {
        post(route('subvehicle.store'), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Asignación Vehículos Subcircuito
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 650, padding: 15, borderRadius: 12 }}>
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
                        className='m-4 w-full'

                    >
                        <Form.Item
                            label='Provincias / Ciudades / Parroquias / Circuitos / Subcircuito'
                            name='dependence'
                            validateStatus={errors.dependence && 'error'}
                            help={errors.dependence}
                            className='mb-4'
                        >
                            <Cascader
                                options={proviceData}
                                size='large'
                                placeholder='Selecciona un Subcircuito'
                                showSearch={{ filter }}
                            />
                        </Form.Item>

                        <div className="mt-5">
                            <InputLabel htmlFor="Usuarios" value="Usuarios" className='mb-2'/>
                            <Table
                                columns={column}
                                dataSource={dataSource}
                                rowSelection={rowSelection}
                                pagination={pagination}
                                onChange={handleTableChange}
                            />
                            <InputError message={errors.modelSelected} className="mt-2 text-[#ff4d4f]" />
                        </div>
                        

                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('subvehicle.index')}>
                                    <Button
                                        size="large"
                                        className="mt-5 shadow-md"
                                    >
                                        Volver
                                    </Button>
                                </Link>
                            </Col>
                            <Col>
                                {permissions.includes('subvehicle.store') && (
                                    <>
                                        <Button
                                            type="primary"
                                            htmlType="submit"
                                            loading={processing}
                                            size="large"
                                            className="mt-5 bg-[#203956]"
                                            disabled={loading || !dataSource.length}

                                        >
                                            Registrar
                                        </Button>
                                    </>
                                )}
                            </Col>
                        </Row>


                    </Form>
                </Card.Grid>
            </div>
        </>
    );
}

Create.layout = page => (<AuthenticatedLayout title="Crear Dependencias" children={page} />)


export default Create