import { PlusOutlined, FrownOutlined, StopOutlined } from '@ant-design/icons';
import { Button, message, Typography, Row, Col, Card, Space, Select, Steps, Menu } from 'antd';
import { Link, usePage } from '@inertiajs/react'
import { useEffect, useState } from 'react';

//PARTIALS
import ShiftInfo from './Partials/ShiftInfo';
import OrderStart from './Partials/OrderStart';
import UserPreviewInfo from '../Users/Partials/UserPreviewInfo'
import VehiclePreviewInfo from '../Vehicles/Partials/VehiclePreviewInfo'
import DependencePreview from '../Subcircuits/Partials/DependencePreview'
import OrderJob from './Partials/OrderJob';
import OrderEnd from './Partials/OrderEnd';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

const { Title } = Typography;

const Show = ({ maintenance, maintenance_types, contracts }) => {

    const { data } = maintenance;
    const { permissions } = usePage().props?.auth || [];
    
    const gridStyle = {
        width: '100%',
        minHeight: '28em',

    };

    const cardStyle = {
        marginTop: '20px',
        marginRight: '15px',
        marginBottom: '5px'
    };

    const [itemSelect, setItemSelect] = useState('shift');
    const [matches, setMatches] = useState(false);

    useEffect(() => {
        const matchQueryList = window.matchMedia("(max-width: 768px)");
        function handleChange(e) {
            setMatches(e.matches);
        }
        matchQueryList.addEventListener("change", handleChange);
    }, [matches]);

    //INFORMACION DE LOS PASOS
    const itemStep = [
        {
            title: 'Solicitud Enviada',
            description: 'El email ya ha sido enviado al encargado.',
        },
        {
            title: 'Solicitud Rechazada',
            description: data.status == 1 ? 'La solicitud del mantenimiento fue rechazada.' : data.status == 0 ? 'No aplica (Solicitud Enviada)' : 'No aplica ( Solicitud Aceptada )',
            //status: data.status > 1 ? 'finish' : '',
            icon: data.status == 1 ? <FrownOutlined /> : <StopOutlined />
        },
        {
            title: 'En Mantenimiento',
            description: 'El vehículo se encuentra en mantenimiento.'
        },
        {
            title: 'En Entrega',
            description: 'El vehículo se está entregando al personal responsable.'
        },
        {
            title: 'Finalizado',
            description: 'Se ha finalizado el mantenimiento del vehículo.',
        },
    ];
    
    //INFORMACION DEL MENU
    const menuItem = [
        {
            key: 'shift',
            label: 'Turno'
        },
        {
            key: 'user',
            label: 'Usuario'
        },
        {
            key: 'vehicle',
            label: 'Vehículo'
        },
        {
            key: 'dependence',
            label: 'Dependencia'
        },
        {
            key: 'order_start',
            label: 'Orden de Recepción',
            disabled: !(data.status >= 2)
        },
        {
            key: 'order_job',
            label: 'Orden de Trabajo',
            disabled: (!(data.status >= 2) || data.maintenance_types.length == 0)
        },
        {
            key: 'order_end',
            label: 'Orden de Entrega',
            disabled: !(data.status >= 3)
        },
    ]


    const getPartialInfo = () => {

        const partial = {
            shift: <ShiftInfo maintenance={data}></ShiftInfo>,
            user: <UserPreviewInfo userPreview={data.user} customTitle={{ title: 'Información de Usuario', level: 4, style: cardStyle }}></UserPreviewInfo>,
            vehicle: <VehiclePreviewInfo modelPreview={data.vehicle} customTitle={{ title: 'Información del Vehículo', level: 4, style: cardStyle }}></VehiclePreviewInfo>,
            dependence: <DependencePreview modelPreview={data.dependence} customTitle={{ title: 'Información de la Depencencia', level: 4, style: cardStyle }}></DependencePreview>,
            order_start: <OrderStart maintenance={data} maintenance_types={maintenance_types} contracts={contracts}></OrderStart>,
            order_job: <OrderJob maintenance={data} maintenance_types={maintenance_types} contracts={contracts}></OrderJob>,
            order_end: <OrderEnd maintenance={data} maintenance_types={maintenance_types} contracts={contracts}></OrderEnd>
        };

        return partial[itemSelect];
    }

    const getItemMenu = ({ item, key }) => {
        setItemSelect(key);
    }

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Mantenimiento
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <Row
                gutter={[20, 16]}
            >
                <Col xs={{ order: 1, span: 24 }} sm={{ order: 1, span: 24 }} md={{ order: 1, span: 24 }} lg={{ order: 0, span: 16 }} xl={{ order: 0, span: 16 }} xxl={{ order: 0, span: 16 }}>
                    <Card style={{ ...gridStyle }} bodyStyle={{ paddingLeft: '5px', paddingRight: '5px', paddingTop: '24px' }} hoverable={false} className='mb-10' type="inner">
                        <Row gutter={[16, 16]}>
                            <Col xs={24} sm={24} md={7} lg={7} xl={7} xxl={7}>
                                <Space direction="vertical" style={{ width: '100%' }}>
                                    <Title level={4} className='pl-4'>
                                        Información
                                    </Title>
                                    <Menu
                                        theme="light"
                                        mode={matches ? "horizontal" : "vertical"}
                                        defaultSelectedKeys={'shift'}
                                        style={{ borderRadius: '0px' }}
                                        items={menuItem}
                                        onSelect={getItemMenu}
                                    />
                                </Space>
                            </Col>
                            <Col xs={24} sm={24} md={17} lg={17} xl={17} xxl={17}>
                                {getPartialInfo()}
                            </Col>
                        </Row>


                    </Card>
                </Col>
                <Col xs={{ order: 0, span: 24 }} sm={{ order: 0, span: 24 }} md={{ order: 0, span: 24 }} lg={{ order: 1, span: 8 }} xl={{ order: 1, span: 8 }} xxl={{ order: 1, span: 8 }}>
                    <Steps
                        direction={matches ? "horizontal" : "vertical"}
                        size="small"
                        current={data.status}
                        items={itemStep}
                        labelPlacement='vertical'
                        responsive={false}
                        style={{ overflowX: matches ? 'scroll' : 'auto' }}
                    />
                </Col>

            </Row>

        </>

    );
}

Show.layout = page => (<AuthenticatedLayout title="Mantenimientos" children={page} />)


export default Show
