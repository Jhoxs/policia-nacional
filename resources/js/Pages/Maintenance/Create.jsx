import { Typography, Button, Form, Input, Checkbox, Row, Col, Space, Card, DatePicker, Select, Modal, Tooltip } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import dayjs from 'dayjs';
import {
    CarOutlined, CalendarOutlined, FileSearchOutlined, DashboardOutlined, BugOutlined, VerifiedOutlined, PicCenterOutlined, VerticalAlignTopOutlined,
    SlidersOutlined, ClockCircleOutlined, UserOutlined, EnvironmentOutlined, SearchOutlined
} from '@ant-design/icons';

import UserPreviewInfo from '../Users/Partials/UserPreviewInfo'
import VehiclePreviewInfo from '../Vehicles/Partials/VehiclePreviewInfo'
import DependencePreview from '../Subcircuits/Partials/DependencePreview'

const { Text, Title } = Typography;
const { RangePicker } = DatePicker;

const Create = ({ vehicle_type, vehicleInfo, userInfo, dependeceInfo, shiftsAvaliable }) => {

    const { mileage } = vehicleInfo.data || '';

    const { data, setData, post, processing, errors } = useForm({
        mileage: '',
        details: '',
        shift_range: '',
        shift_date: '',
    });

    const [isModalOpen, setIsModalOpen] = useState(false);
    const [userPreview, setUserPreview] = useState(false);
    const [isVehicleModalOpen, setVehicleIsModalOpen] = useState(false);
    const [vehiclePreview, setVehiclePreview] = useState(false);
    const [isDepModalOpen, setDepIsModalOpen] = useState(false);
    const [depPreview, setDepPreview] = useState(false);

    const [filterItemValue, setFilterItemValue] = useState('');
    const [searchValue, setSearchValue] = useState('');
    const [searchDate, setSearchDate] = useState('');

    const showModal = data => e => {
        setUserPreview(data);
        setIsModalOpen(true);
    };

    const showVehicleModal = data => e => {
        setVehiclePreview(data);
        setVehicleIsModalOpen(true);
    };

    const showDepModal = data => e => {
        setDepPreview(data);
        setDepIsModalOpen(true);
    };

    const handleCancel = () => {
        setIsModalOpen(false);
        setVehicleIsModalOpen(false);
        setDepIsModalOpen(false);
    };
    

    //DATE FROM TICKET
    const changeDate = (date, dateString) => {
        if (dateString == '') {
            //setSearchDate([dayjs().format('YYYY-MM-DD'),dayjs().format('YYYY-MM-DD')]);
            setSearchDate('');
            handleResetFilterDate();
        } else {
            setSearchDate(dateString);
        }
    }

    const handleFilterDate = () => {
        setData('shift_date', searchDate);
        router.visit(route('maintenance.create', { filterDate: searchDate }), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }

    const handleResetFilterDate = () => {
        setData('shift_range', '');

    }


    const gridStyle = {
        width: '100%',
        padding: '17px'

    };

    const disabledShift = {
        width: '100%',
        background: '#FF4D4F',
        cursor: 'not-allowed'
    };

    const enabledShift = {
        width: '100%',
        cursor: 'pointer'
    };

    const selectedShift = {
        width: '100%',
        cursor: 'pointer',
        background: '#52C41A',
        
    };

    const submit = (e) => {
        /* console.log(data);
        console.log(e); */
        post(route('maintenance.store'), {
            preserveScroll: true
        }, {
            onSuccess: () => {
            }
        });
    };

    const handleShift = data => e => {
        setData('shift_range', data.range);
    }
    
    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Registrar Mantenimiento
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <Row gutter={[16, 16]}>
                <Col xs={24} sm={24} md={18} lg={16} xl={16} xxl={16}>
                    <div className='flex justify-center '>
                        <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: '100%', padding: 15, borderRadius: 12  }} >
                            <Row style={{ width: '90%' }}>
                                <Col xs={24} sm={24} md={24} lg={24} xl={24} xxl={24}>
                                    <Card title={<Title className='mt-3' level={4}>Registro del Turno</Title>} type='inner'>
                                        <Row>
                                            <Col xs={24} sm={24} md={24} lg={12} xl={9} xxl={9}>
                                                <Space direction="vertical">
                                                    <Title level={5} >Búsqueda de turno </Title>
                                                    <Space wrap className='mb-5'>
                                                        <DatePicker
                                                            size='large'
                                                            disabledDate={(current) => {
                                                                return current && current.valueOf() < Date.now();
                                                            }}
                                                            placeholder={'Fecha del Turno'}
                                                            format={'YYYY-MM-DD'}
                                                            onChange={changeDate}
                                                        />

                                                        <Tooltip title="Buscar">
                                                            <Button
                                                                shape="circle"
                                                                icon={<SearchOutlined />}
                                                                onClick={handleFilterDate}
                                                                disabled={(searchDate.length < 1) || (searchDate.length && searchDate[0] == '')}
                                                            />
                                                        </Tooltip>

                                                    </Space>
                                                </Space>
                                            </Col>
                                            <Col xs={24} sm={24} md={24} lg={12} xl={15} xxl={15} align={'center'}>

                                                <Title level={5}>Turnos{data.shift_range != '' ? ' (' + data.shift_range + ')' : null}</Title>
                                                {shiftsAvaliable.length == 0 && (
                                                    <>
                                                        <Card.Grid hoverable={false} style={{ width: '100%' }}>
                                                            <Text>No existen turnos disponibles</Text>
                                                        </Card.Grid>
                                                    </>
                                                )}

                                                {shiftsAvaliable.length >= 0 && (
                                                    shiftsAvaliable.map((shift, index) => {
                                                        let isSelected = shift.range === data.shift_range;
                                                        return (
                                                            <Card.Grid
                                                                key={index}
                                                                hoverable={shift.is_available ? true : false}
                                                                style={shift.is_available ? isSelected ? selectedShift : enabledShift : disabledShift}
                                                                onClick={shift.is_available ? handleShift(shift) : null}
                                                            >
                                                                <Text style={shift.is_available ? isSelected ? {color:'white'} : { color: 'black' } : { color: 'white' }}>{shift.range}</Text>
                                                            </Card.Grid>

                                                        )
                                                    })
                                                )}

                                            </Col>
                                        </Row>
                                    </Card >
                                </Col>
                                <Col xs={24} sm={24} md={24} lg={24} xl={24} xxl={24}>
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
                                            label='Fecha del Turno*'
                                            name='shift_date'
                                            validateStatus={errors.shift_date && 'error'}
                                            help={errors.shift_date}
                                            className='mb-4'
                                        >
                                            <DatePicker
                                                placeholder={data.shift_date == '' ? 'Selecciona una Fecha Turno' : data.shift_date}
                                                disabled={true} size='large'
                                                style={{ width: '100%' }}
                                            />
                                        </Form.Item>

                                        <Form.Item
                                            label='Horario del Turno*'
                                            name='shift_range'
                                            validateStatus={errors.shift_range && 'error'}
                                            help={errors.shift_range}
                                            className='mb-4'
                                        >
                                            <Input
                                                disabled={true}
                                                size='large'
                                                prefix={<ClockCircleOutlined />}
                                                placeholder={data.shift_range == '' ? 'Selecciona una Horario Turno' : data.shift_range}
                                            />

                                        </Form.Item>

                                        <Form.Item
                                            label={!!mileage ? 'Kilometraje* ( ' + mileage + ' )' : 'Kilometraje*'}
                                            name='mileage'
                                            validateStatus={errors.mileage && 'error'}
                                            help={errors.mileage}
                                            className='mb-4'
                                        >
                                            <Input size='large' prefix={<DashboardOutlined />}></Input>
                                        </Form.Item>
                                        <Form.Item
                                            label='Observaciones'
                                            name='details'
                                            validateStatus={errors.details && 'error'}
                                            help={errors.details}
                                            className='mb-4'
                                        >
                                            <Input.TextArea size='large'></Input.TextArea>
                                        </Form.Item>

                                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                                            <Col>
                                                <Link href={route('maintenance.index')}>
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
                                </Col>

                            </Row>


                        </Card.Grid>
                    </div>
                </Col>
                <Col xs={24} sm={24} md={6} lg={8} xl={8} xxl={8} >
                    <Card style={{ cursor: 'inherit', width: '100%' }} hoverable={false} title={<Title className='mt-3' level={4}>Información del Usuario</Title>} className='mb-10' type='inner'>
                        <Tooltip title={'Ver información del usuario'}>
                            <Card.Grid style={{ ...gridStyle, cursor: 'pointer' }} onClick={showModal(userInfo.data)}>
                                <Space size={20}>
                                    <UserOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>Usuario</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                        </Tooltip>
                        <Tooltip title={'Ver información del vehículo'}>
                            <Card.Grid style={{ ...gridStyle, cursor: 'pointer' }} onClick={showVehicleModal(vehicleInfo.data)}>
                                <Space size={20}>
                                    <CarOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>Vehículo</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                        </Tooltip>
                        <Tooltip title={'Ver información de la dependencia'}>
                            <Card.Grid style={{ ...gridStyle, cursor: 'pointer' }} onClick={showDepModal(dependeceInfo.data)}>
                                <Space size={20}>
                                    <EnvironmentOutlined style={{ fontSize: '30px' }} />
                                    <div className='sm:block'>
                                        <div>Dependencia</div>
                                    </div>
                                </Space>
                            </Card.Grid>
                        </Tooltip>
                    </Card>
                </Col>
            </Row>

            <Modal
                style={{ top: 34 }}
                open={isModalOpen}
                closable={false}
                onCancel={handleCancel}
                okButtonProps={{
                    hidden: true,
                }}
                cancelButtonProps={{
                    hidden: true,
                }}
            >
                <UserPreviewInfo userPreview={userPreview} />

            </Modal>

            <Modal
                style={{ top: 34 }}
                open={isVehicleModalOpen}
                closable={false}
                onCancel={handleCancel}
                okButtonProps={{
                    hidden: true,
                }}
                cancelButtonProps={{
                    hidden: true,
                }}
            >
                <VehiclePreviewInfo modelPreview={vehiclePreview} />

            </Modal>

            <Modal
                style={{ top: 34 }}
                open={isDepModalOpen}
                closable={false}
                onCancel={handleCancel}
                okButtonProps={{
                    hidden: true,
                }}
                cancelButtonProps={{
                    hidden: true,
                }}
            >
                <DependencePreview modelPreview={depPreview} />

            </Modal>

        </>

    );
}


Create.layout = page => (<AuthenticatedLayout title="Registrar Mantenimiento" children={page} />)


export default Create
